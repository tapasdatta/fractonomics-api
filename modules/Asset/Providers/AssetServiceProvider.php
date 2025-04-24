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
        $this->loadMigrationsFrom(__DIR__ . "/../Database/migrations");

        $this->mergeConfigFrom(__DIR__ . "/../config.php", "asset");

        $this->app->register(RouteServiceProvider::class);

        // $this->loadRoutesFrom(__DIR__ . "/../routes/web.php");
    }
}
