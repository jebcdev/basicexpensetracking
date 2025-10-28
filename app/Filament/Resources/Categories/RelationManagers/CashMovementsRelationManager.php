<?php

namespace App\Filament\Resources\Categories\RelationManagers;

use App\Filament\Resources\CashMovements\Schemas\CashMovementForm;
use App\Filament\Resources\Categories\CategoryResource;
use App\Filament\Resources\CashMovements\Tables\CashMovementsTable;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class CashMovementsRelationManager extends RelationManager
{
    protected static string $relationship = 'cashMovements';

    public function table(Table $table): Table
    {
        return CashMovementsTable::configure($table)
            ->heading(__('Cash Movements'))
            ->headerActions([
                CreateAction::make()
                    ->label(__('Create Cash Movement'))
                    ->icon('heroicon-s-plus')
                    ->color('primary')
                    ->modalHeading(__('Create Cash Movement'))
                    ->modalSubmitActionLabel(__('Create'))
                    ->modalCancelActionLabel(__('Cancel'))

                ,
            ]);
    }

    public function form(Schema $schema): Schema
    {
        return CashMovementForm::configure($schema);
    }

    public function isReadOnly(): bool
{
    return false;
}
}
