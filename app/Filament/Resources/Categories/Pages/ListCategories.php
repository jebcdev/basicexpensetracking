<?php

namespace App\Filament\Resources\Categories\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use App\Filament\Resources\Categories\CategoryResource;
use Illuminate\Database\Eloquent\Builder;

class ListCategories extends ListRecords
{
    protected static string $resource = CategoryResource::class;
    
protected function getRedirectUrl(): string
{
    return $this->getResource()::getUrl('index');
}
    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

        public function getTabs(): array
    {
        return [
            // Pestaña "Todas" - sin filtro, muestra todos los registros
            'all' => Tab::make('Todas')
                ->icon('heroicon-o-list-bullet')
                ->badge(fn() => CategoryResource::getModel()::count()),

            // Pestaña "Activas" - solo categorías activas
            'active' => Tab::make('Activas')
                ->icon('heroicon-o-check-circle')
                ->modifyQueryUsing(fn(Builder $query) => $query->where('is_active', true))
                ->badge(fn() => CategoryResource::getModel()::where('is_active', true)->count())
                ->badgeColor('success'),

            // Pestaña "Inactivas" - solo categorías inactivas
            'inactive' => Tab::make('Inactivas')
                ->icon('heroicon-o-x-circle')
                ->modifyQueryUsing(fn(Builder $query) => $query->where('is_active', false))
                ->badge(fn() => CategoryResource::getModel()::where('is_active', false)->count())
                ->badgeColor('danger'),
        ];
    }
}
