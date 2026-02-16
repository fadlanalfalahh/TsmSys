<?php

namespace App\Providers;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Form;
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
        TextInput::configureUsing(function (TextInput $component): void {
            $component
                ->autocomplete(false)
                ->autocapitalize(false)
                ->extraInputAttributes([
                    'autocorrect' => 'off',
                    'spellcheck' => 'false',
                ], merge: true);
        });

        Form::configureUsing(function (Form $component): void {
            $component->extraAttributes([
                'novalidate' => true,
            ], merge: true);
        });
    }
}
