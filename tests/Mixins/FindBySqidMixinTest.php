<?php

declare(strict_types=1);

use Workbench\App\Models\Customer;
use Workbench\Database\Factories\CustomerFactory;

it('can find a model by its sqid', function (): void {
    $customer = CustomerFactory::new()->create();
    $sqid = $customer->sqid;

    expect(Customer::findBySqid($sqid))
        ->toBeInstanceOf(Customer::class)
        ->is($customer)->toBeTrue();
});

it('can find a model by its sqid from a specific column', function (): void {
    $customer = CustomerFactory::new()->create();
    $sqid = $customer->sqid;

    expect(Customer::findBySqid($sqid, ['id']))
        ->toBeInstanceOf(Customer::class)
        ->is($customer)->toBeTrue();
});

it('returns null if it cannot find a model with the given sqid', function (): void {
    expect(Customer::findBySqid('missing-sqid'))->toBeNull();
});
