<?php

namespace App\Filament\Resources\CashMovements\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Support\Icons\Heroicon;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class CashMovementInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make()
                    ->columns(2)
                    ->columnSpanFull()
                    ->schema([
                        Section::make(__('User and Parent'))
                            ->icon(Heroicon::OutlinedUser)
                            ->schema([
                                TextEntry::make('user.name')
                                    ->label(__('User'))
                                    ->placeholder('-'),
                                TextEntry::make('parent.title')
                                    ->label(__('Parent'))
                                    ->placeholder('-'),
                            ]),
                        Section::make(__('Category and Type'))
                            ->icon(Heroicon::OutlinedTag)
                            ->schema([
                                TextEntry::make('category.name')
                                    ->label(__('Category'))
                                    ->placeholder('-'),
                                TextEntry::make('type')
                                    ->label(__('Movement Type'))
                                    ->formatStateUsing(fn (?string $state) => $state ? ucfirst(__($state)) : '-')
                                    ,
                            ]),
                    ]),
                Grid::make()
                    ->columns(2)
                    ->columnSpanFull()
                    ->schema([
                        Section::make(__('Financial Details'))
                            ->icon(Heroicon::OutlinedCurrencyDollar)
                            ->schema([
                                TextEntry::make('amount')
                                    ->numeric()
                                    ->label(__('Amount')),
                                TextEntry::make('title')
                                    ->label(__('Title')),
                            ]),
                        Section::make(__('Additional Information'))
                            ->icon(Heroicon::OutlinedDocumentText)
                            ->schema([
                                TextEntry::make('description')
                                    ->label(__('Description'))
                                    ->placeholder('-'),
                                TextEntry::make('date')
                                    ->date()
                                    ->label(__('Date')),
                            ]),
                    ]),
                Section::make(__('Recurrence Settings'))
                    ->icon(Heroicon::OutlinedClock)
                    ->schema([
                        IconEntry::make('is_recurrent')
                            ->boolean()
                            ->label(__('Is Recurrent')),
                        TextEntry::make('recurrent_period')
                            ->label(__('Recurrent Period'))
                            ->placeholder('-'),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
                Section::make(__('Timestamps'))
                    ->icon(Heroicon::OutlinedCalendar)
                    ->schema([
                        TextEntry::make('created_at')
                            ->dateTime()
                            ->label(__('Created At'))
                            ->placeholder('-'),
                        TextEntry::make('updated_at')
                            ->dateTime()
                            ->label(__('Updated At'))
                            ->placeholder('-'),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
            ]);
    }
}
