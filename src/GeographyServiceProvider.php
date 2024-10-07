<?php

namespace DazzaDev\Geography;

use Illuminate\Support\ServiceProvider;

class GeographyServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../database/migrations/' => database_path('migrations'),
            __DIR__.'/../database/data/' => database_path('data'),
            __DIR__.'/../database/seeders/' => database_path('seeders'),
        ], 'laravel-geography');
    }

    /**
     * Register the application services.
     */
    public function register(): void
    {
        $this->app->singleton('laravel-geography', function () {
            return new Geography;
        });

        require_once __DIR__.'/Helpers/helpers.php';
    }
}
