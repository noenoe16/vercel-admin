<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class FilamentLanguageSwitcherServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->commands([
            \App\Console\FilamentLanguageSwitcherInstall::class,
        ]);

        // Register Config file
        $this->mergeConfigFrom(base_path('config/filament-language-switcher.php'), 'filament-language-switcher');

        // Publish Config
        $this->publishes([
            base_path('config/filament-language-switcher.php') => config_path('filament-language-switcher.php'),
        ], 'filament-language-switcher-config');

        // Register Migrations
        $this->loadMigrationsFrom(database_path('migrations'));

        // Publish Migrations
        $this->publishes([
            database_path('migrations') => database_path('migrations'),
        ], 'filament-language-switcher-migrations');

        // Register views
        $this->loadViewsFrom(resource_path('views/filament/filament-language-switcher'), 'filament-language-switcher');

        // Publish Views
        $this->publishes([
            resource_path('views/filament/filament-language-switcher') => resource_path('views/filament/filament-language-switcher'),
        ], 'filament-language-switcher-views');

        // Register Langs
        $this->loadTranslationsFrom(base_path('lang/filament-language-switcher'), 'filament-language-switcher');

        // Publish Lang
        $this->publishes([
            base_path('lang/filament-language-switcher') => base_path('lang/filament-language-switcher'),
        ], 'filament-language-switcher-lang');

        // Register Routes
        $this->loadRoutesFrom(base_path('routes/web.php'));
    }

    public function boot(): void
    {
        // you boot methods here
    }
}
