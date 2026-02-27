<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Collection;
use Workbench\App\Models\Customer;
use Workbench\Database\Factories\CustomerFactory;

it('can query a model by its sqid', function (): void {
    $customer = CustomerFactory::new()->create();

    CustomerFactory::new()->count(10)->create();

    $customers = Customer::query()
        ->whereSqid($customer->sqid)
        ->get();

    expect($customers)
        ->toBeInstanceOf(Collection::class)
        ->toHaveCount(1)
        ->first()->toBeInstanceOf(Customer::class)
        ->first()->is($customer);
});
