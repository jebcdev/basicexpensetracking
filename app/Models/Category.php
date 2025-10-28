<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'color',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function cashMovements(): HasMany
    {
        return $this->hasMany(CashMovement::class);
    }

    public function scopeIsActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeIsInactive($query)
    {
        return $query->where('is_active', false);
    }

    public function scopeOrderedByName($query)
    {
        return $query->orderBy('name');
    }

    public function scopeOrderedByCreatedAt($query)
    {
        return $query->orderBy('created_at');
    }
}
