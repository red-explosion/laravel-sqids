<?php

declare(strict_types=1);

use RedExplosion\Sqids\Prefixes\ConsonantPrefix;
use Workbench\App\Models\Charge;
use Workbench\App\Models\Customer;

it(description: 'can generate a prefix without vowels', closure: function (): void {
    expect(new ConsonantPrefix())
        ->prefix(model: Customer::class)
        ->toBe(expected: 'cst')
        ->prefix(model: Charge::class)
        ->toBe(expected: 'chr');
    ;
});
