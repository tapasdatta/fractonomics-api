<?php

namespace Modules\Asset\Providers;

use Illuminate\Support\ServiceProvider;

class AssetServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . "/../../database/migrations");

        $this->mergeConfigFrom(__DIR__ . "/../../config/config.php", "asset");

        $this->app->register(EventServiceProvider::class);
        $this->app->register(RouteServiceProvider::class);
    }
}
