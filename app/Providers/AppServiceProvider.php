<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Ensure PHP's runtime timezone matches `config('app.timezone')`.
        // This makes PHP date functions and Carbon use the configured timezone
        // even if the system/php.ini has a different default.
        date_default_timezone_set(config('app.timezone'));


        \App\Models\CashMovement::observe(\App\Observers\CashMovementObserver::class);


        \Filament\Tables\Columns\TextColumn::macro('searchableAndSortable', function () {
            /** @var \Filament\Tables\Columns\TextColumn $this */
            return $this->searchable()->sortable();
        });

        \Filament\Tables\Columns\IconColumn::macro('searchableAndSortable', function () {
            /** @var \Filament\Tables\Columns\IconColumn $this */
            return $this->searchable()->sortable();
        });


        \Filament\Tables\Columns\ColorColumn::macro('searchableAndSortable', function () {
            /** @var \Filament\Tables\Columns\ColorColumn $this */
            return $this->searchable()->sortable();
        });
    }
}
