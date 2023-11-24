<?php

declare(strict_types=1);

use RedExplosion\Sqids\Tests\TestModels\TestModel;
use Sqids\Sqids;

it('can generate a sqid attribute', function (): void {
    $model = TestModel::create(['name' => 'foo']);

    $sqids = new Sqids();

    expect($model->id)
        ->not->toBeNull()
        ->and($model->sqid)
        ->not->toBeNull()
        ->not->toBe($model->id)
        ->and($sqids->decode($model->sqid)[0])
        ->toBe($model->id);
});
