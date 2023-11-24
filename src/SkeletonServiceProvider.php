<?php

declare(strict_types=1);

namespace RedExplosion\Skeleton;

use Illuminate\Support\ServiceProvider;

class SkeletonServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(
            path: __DIR__ . '/../config/skeleton.php',
            key: 'skeleton',
        );
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes(
                paths: [
                    __DIR__ . '/../config/skeleton.php' => config_path('skeleton.php'),
                ],
                groups: 'skeleton-config',
            );
        }
    }
}
