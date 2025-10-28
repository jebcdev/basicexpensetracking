<?php

namespace App\Filament\Resources\CashMovements\Tables;

use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Grouping\Group;

use Illuminate\Support\Facades\Auth;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;

use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\Summarizers\Summarizer;
use App\Filament\Resources\CashMovements\CashMovementResource;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\DatePicker;
use  Illuminate\Database\Eloquent\Builder as FilterBuilder;

class CashMovementsTable
{
    public static function configure(Table $table): Table
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();
        $isAdmin = $user->isAdmin();


        return $table
            ->columns([

                TextColumn::make('user.name')
                    ->label(__('User'))
                    ->searchableAndSortable()
                    ->visible($isAdmin),

                TextColumn::make('date')
                    ->label(__('Date'))
                    ->dateTime()
                    ->since()
                    ->dateTooltip()
                    ->searchableAndSortable(),

                TextColumn::make('category.name')
                    ->label(__('Category'))
                    ->formatStateUsing(fn($state, $record) => "<span style='background-color: {$record->category->color}; color: black; padding: 2px 6px; border-radius: 4px; font-size: 0.75rem;'>{$state}</span>")
                    ->html()
                    ->searchableAndSortable(),

                TextColumn::make('type')
                    ->label(__('Type'))
                    ->formatStateUsing(fn(string $state): string => __($state))
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'income' => 'success',
                        'expense' => 'danger',
                    })
                    ->searchableAndSortable(),

                TextColumn::make('amount')
                    ->label(__('Amount'))
                    ->money('COP', decimalPlaces: 0)
                    ->summarize([
                        Sum::make()
                            ->label(__('Income Total'))
                            ->query(fn(Builder $query) => $query->where('type', 'income')),
                        Sum::make()
                            ->label(__('Expense Total'))
                            ->query(fn(Builder $query) => $query->where('type', 'expense')),
                        Summarizer::make()
                            ->label(__('Difference (Income - Expense)'))
                            ->using(fn(Builder $query) => $query->sum(DB::raw("CASE WHEN type = 'income' THEN amount ELSE -amount END"))),
                    ])
                    ->searchableAndSortable(),

                TextColumn::make('title')
                    ->label(__('Title'))
                    ->limit(20)
                    ->searchableAndSortable(),

                TextColumn::make('parent.title')
                    ->label(__('Parent'))
                    ->searchableAndSortable()
                    ->searchable(),

                IconColumn::make('is_recurrent')
                    ->label(__('Is Recurrent'))
                    ->searchableAndSortable()
                    ->boolean(),

                TextColumn::make('recurrent_period')
                    ->label(__('Recurrent Period'))
                    ->formatStateUsing(fn(string $state): string => __($state))
                    ->searchableAndSortable(),

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
                    ->since()
                    ->dateTooltip()
                    ->searchableAndSortable()
                    ->toggleable(isToggledHiddenByDefault: true),

            ])
            ->filters([
                Filter::make('date_range')
                    ->schema([
                        DatePicker::make('from_date')->label(__('From Date')),
                        DatePicker::make('to_date')->label(__('To Date')),
                    ])
                    ->query(function (FilterBuilder $query, array $data): FilterBuilder {
                        return $query
                            ->when(
                                $data['from_date'],
                                fn(FilterBuilder $query, $date): FilterBuilder => $query->whereDate('date', '>=', $date),
                            )
                            ->when(
                                $data['to_date'],
                                fn(FilterBuilder $query, $date): FilterBuilder => $query->whereDate('date', '<=', $date),
                            );
                    }),
            ])
            ->recordActions([
                \Filament\Actions\ActionGroup::make([
                    ViewAction::make()->url(fn($record) => CashMovementResource::getUrl('view', ['record' => $record]))->label(__('View')),
                    EditAction::make()->label(__('Edit')),
                    \Filament\Actions\DeleteAction::make()->label(__('Delete')),
                ]),
            ], position: \Filament\Tables\Enums\RecordActionsPosition::BeforeColumns)
            ->toolbarActions([
                // Acciones masivas agrupadas: eliminar, forzar eliminación,
                // restaurar. Se usan las implementaciones nativas de Filament.
                BulkActionGroup::make([
                    DeleteBulkAction::make(),

                ]),
            ])
            ->groups([
                Group::make('type')
                    ->label(__('Type'))
                    ->collapsible()
                    ->titlePrefixedWithLabel(true)
                    ->getTitleFromRecordUsing(fn($record) => __($record->type)),
            ]);
    }
}
