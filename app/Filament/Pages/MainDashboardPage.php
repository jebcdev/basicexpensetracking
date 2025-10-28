<?php

namespace App\Filament\Pages;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\DatePicker;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;

class MainDashboardPage extends BaseDashboard
{

    use HasFiltersForm;

    protected static ?int $sort = -1;

    public function filtersForm(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('Filter by Date Range'))
                    ->schema([

                        DatePicker::make('startDate')
                            ->label(__('Start Date'))
                            ->maxDate(fn(Get $get) => $get('endDate') ?: now())
                            ->live(),
                        DatePicker::make('endDate')
                            ->label(__('End Date'))
                            ->minDate(fn(Get $get) => $get('startDate'))
                            ->live(),
                    ])
                    ->columns(2)
                    ->columnSpanFull()
                    ->collapsible(true),
            ]);
    }

    protected function getHeaderWidgets(): array
    {
        return

            [
                // CashMovementsStatsOverviewWidget::class
            ];
    }
}
