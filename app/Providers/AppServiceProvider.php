<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

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
    public function boot()
    {
        Livewire::component('filament.widgets.part-table-widget', \App\Filament\Widgets\PartTableWidget::class);
        Livewire::component('filament.widgets.rm-table-widget', \App\Filament\Widgets\RmTableWidget::class);

        Livewire::component('filament.widgets.part-approved-table-widget', \App\Filament\Widgets\ApprovedPartTableWidget::class);
        Livewire::component('filament.widgets.rm-approved-table-widget', \App\Filament\Widgets\ApprovedRMTableWidget::class);

        Livewire::component('filament.widgets.part-disapproved-table-widget', \App\Filament\Widgets\DisapprovedPartTableWidget::class);
        Livewire::component('filament.widgets.rm-disapproved-table-widget', \App\Filament\Widgets\DisapprovedRMTableWidget::class);
    }
}
