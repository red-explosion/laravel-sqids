<?php

declare(strict_types=1);

use RedExplosion\Sqids\Prefixes\SimplePrefix;
use Workbench\App\Models\Charge;
use Workbench\App\Models\Customer;

it(description: 'can generate a default prefix', closure: function (): void {
    expect(new SimplePrefix())
        ->prefix(model: Customer::class)
        ->toBe(expected: 'cus')
        ->prefix(model: Charge::class)
        ->toBe(expected: 'cha');
    ;
});
