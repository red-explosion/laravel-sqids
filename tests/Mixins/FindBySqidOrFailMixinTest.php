<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Workbench\App\Models\Customer;
use Workbench\Database\Factories\CustomerFactory;

it(description: 'can find or fail a model by its sqid', closure: function (): void {
    $customer = CustomerFactory::new()->create();
    $sqid = $customer->sqid;

    expect(Customer::findBySqidOrFail(sqid: $sqid))
        ->toBeInstanceOf(Customer::class)
        ->is($customer)->toBeTrue();

    $this->expectException(ModelNotFoundException::class);

    Customer::findBySqidOrFail(sqid: 'missing-sqid');
});

it(description: 'can find or fail a model by its sqid from a specific column', closure: function (): void {
    $customer = CustomerFactory::new()->create();
    $sqid = $customer->sqid;

    expect(Customer::findBySqidOrFail(sqid: $sqid, columns: ['id']))
        ->toBeInstanceOf(Customer::class)
        ->is($customer)->toBeTrue();

    $this->expectException(ModelNotFoundException::class);

    Customer::findBySqidOrFail(sqid: 'missing-sqid', columns: ['id']);
});
