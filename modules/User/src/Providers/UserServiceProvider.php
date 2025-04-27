<?php

namespace Modules\User\Providers;

use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . "/../../database/migrations");

        $this->mergeConfigFrom(__DIR__ . "/../../config/config.php", "user");

        $this->app->register(RouteServiceProvider::class);
    }
}
