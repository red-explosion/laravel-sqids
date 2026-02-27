<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Workbench\App\Models\Customer;
use Workbench\Database\Factories\CustomerFactory;

it('can find or fail a model by its sqid', function (): void {
    $customer = CustomerFactory::new()->create();
    $sqid = $customer->sqid;

    expect(Customer::findBySqidOrFail($sqid))
        ->toBeInstanceOf(Customer::class)
        ->is($customer)->toBeTrue();

    $this->expectException(ModelNotFoundException::class);

    Customer::findBySqidOrFail('missing-sqid');
});

it('can find or fail a model by its sqid from a specific column', function (): void {
    $customer = CustomerFactory::new()->create();
    $sqid = $customer->sqid;

    expect(Customer::findBySqidOrFail($sqid, ['id']))
        ->toBeInstanceOf(Customer::class)
        ->is($customer)->toBeTrue();

    $this->expectException(ModelNotFoundException::class);

    Customer::findBySqidOrFail('missing-sqid', ['id']);
});
