<?php

namespace App\Filament\Resources\Categories\Tables;

use App\Filament\Resources\Categories\CategoryResource;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class CategoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(__('Name'))
                    ->searchableAndSortable(),

                ColorColumn::make('color')
                    ->label(__('Color'))
                    ->searchableAndSortable(),

                IconColumn::make('is_active')
                    ->label(__('Active'))
                    ->boolean(),

                TextColumn::make('created_at')
                    ->label(__('Created At'))
                    ->dateTime()
                    ->since()
                    ->dateTooltip()
                    ->searchableAndSortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label(__('Updated At'))
                    ->dateTime()
                    ->searchableAndSortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('deleted_at')
                    ->label(__('Deleted At'))
                    ->dateTime()
                    ->searchableAndSortable()
                    ->toggleable(isToggledHiddenByDefault: true),

            ])
            ->filters([
                TrashedFilter::make(),

            ])
            ->recordActions([
                \Filament\Actions\ActionGroup::make([
                    ViewAction::make()->url(fn($record) => CategoryResource::getUrl('view', ['record' => $record]))->label(__('View')),

                    EditAction::make()->label(__('Edit')),

                    \Filament\Actions\DeleteAction::make()->label(__('Delete')),

                    \Filament\Actions\RestoreAction::make()->label(__('Restore')),

                    \Filament\Actions\ForceDeleteAction::make()->label(__('Force Delete')),

                ]),

            ], position: \Filament\Tables\Enums\RecordActionsPosition::BeforeColumns)
            ->toolbarActions([
                // Acciones masivas agrupadas: eliminar, forzar eliminación,
                // restaurar. Se usan las implementaciones nativas de Filament.
                BulkActionGroup::make([
                    DeleteBulkAction::make(),

                    ForceDeleteBulkAction::make(),

                    RestoreBulkAction::make(),

                ]),

            ]);
    }
}
