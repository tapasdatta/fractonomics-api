<?php

namespace Modules\Asset\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Modules\Asset\Models\Asset;
use Modules\Asset\Policies\UpdateAssetStatusPolicy;

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

        Gate::policy(Asset::class, UpdateAssetStatusPolicy::class);
    }
}
