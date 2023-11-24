<?php

declare(strict_types=1);

namespace RedExplosion\Sqids\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use RedExplosion\Sqids\SqidsServiceProvider;

abstract class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            SqidsServiceProvider::class,
        ];
    }
}
