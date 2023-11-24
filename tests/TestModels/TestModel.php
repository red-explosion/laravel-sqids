<?php

declare(strict_types=1);

namespace RedExplosion\Sqids\Tests\TestModels;

use Illuminate\Database\Eloquent\Model;
use RedExplosion\Sqids\Sqids;

class TestModel extends Model
{
    use Sqids;

    protected $guarded = [];
}
