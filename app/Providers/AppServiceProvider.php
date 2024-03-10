<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Validation\ValidationException;
use BezhanSalleh\PanelSwitch\PanelSwitch;

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
        
        // PanelSwitch::configureUsing(function (PanelSwitch $panelSwitch) {
        //     $panelSwitch
        //         ->slideOver()
        //         ->modalWidth('sm')
        //         ->excludes([
        //             'teacher',
        //             'student',
        //         ])
        //         ->visible(fn (): bool => auth()->user()->role->slug == 'administrator')
        //         ->canSwitchPanels(fn (): bool => auth()->user()->role->slug == 'administrator');
        // });
        // Page::$reportValidationErrorUsing = function (ValidationException $exception) {
        //     Notification::make()
        //         ->title($exception->getMessage())
        //         ->danger()
        //         ->send();
        // };
    }
}
