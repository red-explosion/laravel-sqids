<?php

declare(strict_types=1);

use RedExplosion\Sqids\Prefixes\ConsonantPrefix;
use Workbench\App\Models\Charge;
use Workbench\App\Models\Customer;

it('can generate a prefix without vowels', function (): void {
    expect(new ConsonantPrefix())
        ->prefix(Customer::class)
        ->toBe('cst')
        ->prefix(Charge::class)
        ->toBe('chr');
});
