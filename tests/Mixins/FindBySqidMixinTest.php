<?php

declare(strict_types=1);

use Workbench\App\Models\Customer;
use Workbench\Database\Factories\CustomerFactory;

it(description: 'can find a model by its sqid', closure: function (): void {
    $customer = CustomerFactory::new()->create();
    $sqid = $customer->sqid;

    expect(Customer::findBySqid(sqid: $sqid))
        ->toBeInstanceOf(Customer::class)
        ->is($customer)->toBeTrue();
});

it(description: 'can find a model by its sqid from a specific column', closure: function (): void {
    $customer = CustomerFactory::new()->create();
    $sqid = $customer->sqid;

    expect(Customer::findBySqid(sqid: $sqid, columns: ['id']))
        ->toBeInstanceOf(Customer::class)
        ->is($customer)->toBeTrue();
});

it(description: 'returns null if it cannot find a model with the given sqid', closure: function (): void {
    expect(Customer::findBySqid(sqid: 'missing-sqid'))
        ->toBeNull();
});
