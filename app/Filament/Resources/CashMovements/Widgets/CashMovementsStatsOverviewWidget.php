<?php

namespace App\Filament\Resources\CashMovements\Widgets;

use App\Enums\CashMovementType;
use App\Filament\Resources\CashMovements\Pages\ListCashMovements;
use Carbon\Carbon;
use Filament\Schemas\Components\Section;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class CashMovementsStatsOverviewWidget extends StatsOverviewWidget
{
    use InteractsWithPageFilters;

    /**
     * Override trait property to allow null assignment from Livewire payloads
     * (some Livewire requests may send null and PHP typed non-nullable arrays
     * would throw a TypeError). Making this nullable avoids the error.
     *
     * @var array<string, string|array<string,string|null>|null>|null
     */
    public ?array $tableColumnSearches = [];

    // protected ?string $pollingInterval = null;

    protected static ?int $sort = 99;

    protected function getTablePage(): string
    {
        return ListCashMovements::class;
    }
    protected function getStats(): array
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();

        $startDate = $this->pageFilters['startDate'] ?? null;
        $endDate = $this->pageFilters['endDate'] ?? null;

        $totalMovements = 0;
        $totalIncome = 0;
        $totalExpense = 0;
        $difference = 0;

        if ($user->isAdmin()) {
            $baseQuery = \App\Models\CashMovement::query();
            if ($startDate) $baseQuery->where('date', '>=', $startDate);
            if ($endDate) $baseQuery->where('date', '<=', $endDate);
            $totalMovements = $baseQuery->count();
            $totalIncome = $baseQuery->clone()->where('type', CashMovementType::income->value)->sum('amount');
            $totalExpense = $baseQuery->clone()->where('type', CashMovementType::expense->value)->sum('amount');
            $difference = $totalIncome - $totalExpense;
        } else {
            $baseQuery = $user->cashMovements();
            if ($startDate) $baseQuery->where('date', '>=', $startDate);
            if ($endDate) $baseQuery->where('date', '<=', $endDate);
            $totalMovements = $baseQuery->count();
            $totalIncome = $baseQuery->clone()->where('type', CashMovementType::income->value)->sum('amount');
            $totalExpense = $baseQuery->clone()->where('type', CashMovementType::expense->value)->sum('amount');
            $difference = $totalIncome - $totalExpense;
        }

        /* Format in COP money */
        $formatter = new \NumberFormatter('es_CO', \NumberFormatter::CURRENCY);
        $totalIncomeFormatted = $formatter->formatCurrency($totalIncome, 'COP');
        $totalExpenseFormatted = $formatter->formatCurrency($totalExpense, 'COP');
        $differenceFormatted = $formatter->formatCurrency($difference, 'COP');


        return [
            Section::make(__('Cash Movements Overview'))
            ->collapsible(true)
                ->schema([
                    // Stat::make('Total Movimientos', $totalMovements),
                    Stat::make(__('Income Total'), $totalIncomeFormatted),
                    Stat::make(__('Expense Total'), $totalExpenseFormatted),
                    Stat::make(__('Difference (Income - Expense)'), $differenceFormatted)
                ])->columns(3)->columnSpanFull()
        ];
    }
}
