<?php

declare(strict_types=1);

namespace RedExplosion\Sqids\Tests;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Orchestra\Testbench\TestCase as Orchestra;
use RedExplosion\Sqids\SqidsServiceProvider;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            SqidsServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app): void
    {
        Schema::create(table: 'test_models', callback: function (Blueprint $table): void {
            $table->id();
            $table->string(column: 'name');
            $table->timestamps();
        });
    }
}
