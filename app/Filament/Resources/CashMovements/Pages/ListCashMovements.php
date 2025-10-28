<?php

namespace App\Filament\Resources\CashMovements\Pages;


use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;

use App\Filament\Resources\CashMovements\CashMovementResource;
use Illuminate\Database\Eloquent\Builder;

class ListCashMovements extends ListRecords
{
    use HasFiltersForm;

    protected static string $resource = CashMovementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    /**
     * Define las pestañas (tabs) para filtrar el listado de categorías.
     *
     * Cada pestaña aplica un filtro diferente sobre la query base:
     * - 'all': Muestra todas las categorías sin filtro
     * - 'active': Filtra solo las categorías activas (is_active = true)
     * - 'inactive': Filtra solo las categorías inactivas (is_active = false)
     *
     * @return array Array asociativo de pestañas [clave => Tab]
     */
    public function getTabs(): array
    {
        return [
            // Pestaña "Todas" - sin filtro, muestra todos los registros
            'all' => Tab::make(__('All'))
                ->icon('heroicon-o-list-bullet')
                ->badge(fn() => CashMovementResource::getModel()::count()),


                'income' => Tab::make(__('Income'))
                ->icon('heroicon-o-check-circle')
                ->modifyQueryUsing(fn(Builder $query) => $query->where('type',\App\Enums\CashMovementType::income))
                ->badge(fn() => CashMovementResource::getModel()::where('type',\App\Enums\CashMovementType::income)->count())
                ->badgeColor('success'),

                'expense' => Tab::make(__('Expense'))
                ->icon('heroicon-o-x-circle')
                ->modifyQueryUsing(fn(Builder $query) => $query->where('type',\App\Enums\CashMovementType::expense))
                ->badge(fn() => CashMovementResource::getModel()::where('type',\App\Enums\CashMovementType::expense)->count())
                ->badgeColor('danger'),

        ];
    }
}
