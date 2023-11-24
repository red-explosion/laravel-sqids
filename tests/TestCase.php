<?php

declare(strict_types=1);

namespace RedExplosion\Skeleton\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use RedExplosion\Skeleton\SkeletonServiceProvider;

abstract class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            SkeletonServiceProvider::class,
        ];
    }
}
