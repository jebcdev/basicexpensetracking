<?php

namespace App\Filament\Resources\CashMovements;

use App\Filament\Resources\CashMovements\Pages\CreateCashMovement;
use App\Filament\Resources\CashMovements\Pages\EditCashMovement;
use App\Filament\Resources\CashMovements\Pages\ListCashMovements;
use App\Filament\Resources\CashMovements\Pages\ViewCashMovement;
use App\Filament\Resources\CashMovements\Schemas\CashMovementForm;
use App\Filament\Resources\CashMovements\Schemas\CashMovementInfolist;
use App\Filament\Resources\CashMovements\Tables\CashMovementsTable;
use App\Filament\Resources\CashMovements\Widgets\CashMovementsStatsOverviewWidget;
use App\Models\CashMovement;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class CashMovementResource extends Resource
{
    protected static ?string $model = CashMovement::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBanknotes;

    protected static ?string $recordTitleAttribute = 'title';

    /*  Inicio de Personalización  */

    public static function getNavigationLabel(): string
    {
        // Define el nombre en singular para la navegación lateral
        $text = __('Cash Movements');
        return $text;
    }

    // Opcional: Cambiar los nombres usados en los títulos y Breadcrumbs
    public static function getModelLabel(): string
    {
        $text = __('Cash Movement');
        return $text; // Usado en 'Crear'
    }

    public static function getPluralModelLabel(): string
    {
        $text = __('Cash Movements');
        return $text; // Usado en el título principal 'Lista de ...'
    }

    public static function getNavigationSort(): ?int
    {

        return 2;
    }

    public static function getNavigationBadge(): ?string
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();
        if ($user && $user->isAdmin()) {
            return static::getModel()::count();
        } else {
            return static::getModel()::where('user_id', $user->id)->count();
        }
    }

    public static function getNavigationBadgeTooltip(): ?string
    {
        $text = __('Total Cash Movements Registered');
        return $text;
    }

    /*  Fin de Personalización  */

    public static function getEloquentQuery(): Builder
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();
        $query = parent::getEloquentQuery();
        if ($user && !$user->isAdmin()) {
            $query->where('user_id', $user->id);
        }
        return $query;
    }

    public static function form(Schema $schema): Schema
    {
        return CashMovementForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return CashMovementInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CashMovementsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCashMovements::route('/'),
            'create' => CreateCashMovement::route('/create'),
            'view' => ViewCashMovement::route('/{record}'),
            'edit' => EditCashMovement::route('/{record}/edit'),
        ];
    }

    public static function getWidgets(): array
    {
        return [
            // CashMovementsStatsOverviewWidget::class,
        ];
    }
}
