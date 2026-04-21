<?php

namespace Gadhyare\HornPay;

use Illuminate\Support\ServiceProvider;

class HornPayServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/horn-pay.php', 'horn-pay'
        );

        $this->app->singleton('horn-pay', function ($app) {
            return new HornPayManager($app);
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/horn-pay.php' => config_path('horn-pay.php'),
            ], 'horn-pay-config');
        }

        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
    }
}
