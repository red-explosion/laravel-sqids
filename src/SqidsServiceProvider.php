<?php

declare(strict_types=1);

namespace RedExplosion\Sqids;

use Illuminate\Support\ServiceProvider;

class SqidsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(
            path: __DIR__ . '/../config/sqids.php',
            key: 'sqids',
        );
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes(
                paths: [
                    __DIR__ . '/../config/sqids.php' => config_path('sqids.php'),
                ],
                groups: 'sqids-config',
            );
        }
    }
}
