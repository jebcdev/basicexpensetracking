<?php

namespace App\Models;

use App\Enums\CashMovementRecurrentPeriod;
use App\Enums\CashMovementType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CashMovement extends Model
{

    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'parent_id',
        'type',
        'amount',
        'title',
        'description',
        'date',
        'is_recurrent',
        'recurrent_period',

    ];

    protected $casts = [
        'type' => 'string',
        'amount' => 'decimal:2',
        'date' => 'date',
        'is_recurrent' => 'boolean',
        'recurrent_period' => 'string',
        'parent_id' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(CashMovement::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(CashMovement::class, 'parent_id');
    }



    public function scopeIsExpense($query)
    {
        return $query->where('type', CashMovementType::expense->value);
    }

    public function scopeIsIncome($query)
    {
        return $query->where('type', CashMovementType::income->value);
    }

    public function scopeIsRecurrent($query)
    {
        return $query->where('is_recurrent', true);
    }

    public function createRecurringChildren()
    {
        $period = $this->recurrent_period;
        $startDate = $this->date;
        $children = [];

        switch ($period) {
            case CashMovementRecurrentPeriod::daily->value:
                for ($i = 1; $i <= 364; $i++) {
                    $children[] = [
                        'user_id' => $this->user_id,
                        'category_id' => $this->category_id,
                        'type' => $this->type,
                        'amount' => $this->amount,
                        'title' => $this->title,
                        'description' => $this->description,
                        'date' => $startDate->copy()->addDays($i),
                        'is_recurrent' => false,
                        'parent_id' => $this->id,
                    ];
                }
                break;
            case CashMovementRecurrentPeriod::weekly->value:
                for ($i = 1; $i <= 51; $i++) {
                    $children[] = [
                        'user_id' => $this->user_id,
                        'category_id' => $this->category_id,
                        'type' => $this->type,
                        'amount' => $this->amount,
                        'title' => $this->title,
                        'description' => $this->description,
                        'date' => $startDate->copy()->addWeeks($i),
                        'is_recurrent' => false,
                        'parent_id' => $this->id,
                    ];
                }
                break;
            case CashMovementRecurrentPeriod::monthly->value:
                for ($i = 1; $i <= 11; $i++) {
                    $children[] = [
                        'user_id' => $this->user_id,
                        'category_id' => $this->category_id,
                        'type' => $this->type,
                        'amount' => $this->amount,
                        'title' => $this->title,
                        'description' => $this->description,
                        'date' => $startDate->copy()->addMonths($i),
                        'is_recurrent' => false,
                        'parent_id' => $this->id,
                    ];
                }
                break;
            case CashMovementRecurrentPeriod::yearly->value:
                for ($i = 1; $i <= 4; $i++) {
                    $children[] = [
                        'user_id' => $this->user_id,
                        'category_id' => $this->category_id,
                        'type' => $this->type,
                        'amount' => $this->amount,
                        'title' => $this->title,
                        'description' => $this->description,
                        'date' => $startDate->copy()->addYears($i),
                        'is_recurrent' => false,
                        'parent_id' => $this->id,
                    ];
                }
                break;
        }

        CashMovement::insert($children);
    }

    /**
     * Suma total de ingresos en un rango de fechas opcional
     *
     * @param string|null $startDate Fecha inicial (formato Y-m-d)
     * @param string|null $endDate Fecha final (formato Y-m-d)
     * @return float
     */
    public function scopeTotalIncome($query, $startDate = null, $endDate = null)
    {
        $query = $query->where('type', CashMovementType::income->value);

        if ($startDate && $endDate) {
            $query->whereBetween('date', [$startDate, $endDate]);
        } elseif ($startDate) {
            $query->where('date', '>=', $startDate);
        } elseif ($endDate) {
            $query->where('date', '<=', $endDate);
        }

        return $query->sum('amount');
    }

    /**
     * Suma total de gastos en un rango de fechas opcional
     *
     * @param string|null $startDate Fecha inicial (formato Y-m-d)
     * @param string|null $endDate Fecha final (formato Y-m-d)
     * @return float
     */
    public function scopeTotalExpense($query, $startDate = null, $endDate = null)
    {
        $query = $query->where('type', CashMovementType::expense->value);

        if ($startDate && $endDate) {
            $query->whereBetween('date', [$startDate, $endDate]);
        } elseif ($startDate) {
            $query->where('date', '>=', $startDate);
        } elseif ($endDate) {
            $query->where('date', '<=', $endDate);
        }

        return $query->sum('amount');
    }

    /**
     * Calcula el balance (ingresos - gastos) en un rango de fechas opcional
     *
     * @param string|null $startDate Fecha inicial (formato Y-m-d)
     * @param string|null $endDate Fecha final (formato Y-m-d)
     * @return float
     */
    public function scopeBalance($query, $startDate = null, $endDate = null)
    {
        $incomeQuery = clone $query;
        $expenseQuery = clone $query;

        $totalIncome = $incomeQuery->totalIncome($startDate, $endDate);
        $totalExpense = $expenseQuery->totalExpense($startDate, $endDate);

        return $totalIncome - $totalExpense;
    }

    /**
     * Obtiene el movimiento más antiguo
     *
     * @param \App\Models\User|null $user Usuario para filtrar (si no es admin)
     * @return \App\Models\CashMovement|null
     */
    public static function getOldestMovement($user = null)
    {
        $query = self::query();
        if ($user && !$user->isAdmin()) {
            $query->where('user_id', $user->id);
        }
        return $query->orderBy('date', 'asc')->first();
    }

    /**
     * Obtiene el movimiento más reciente
     *
     * @param \App\Models\User|null $user Usuario para filtrar (si no es admin)
     * @return \App\Models\CashMovement|null
     */
    public static function getNewestMovement($user = null)
    {
        $query = self::query();
        if ($user && !$user->isAdmin()) {
            $query->where('user_id', $user->id);
        }
        return $query->orderBy('date', 'desc')->first();
    }
}
