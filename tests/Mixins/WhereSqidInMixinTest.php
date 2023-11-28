<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Collection;
use Workbench\App\Models\Customer;
use Workbench\Database\Factories\CustomerFactory;

it(description: 'can query all models with the given sqids', closure: function (): void {
    $customer = CustomerFactory::new()->create();

    CustomerFactory::new()->count(count: 10)->create();

    $customers = Customer::query()
        ->whereSqidIn(column: 'id', sqids: [$customer->sqid])
        ->get();

    expect($customers)
        ->toBeInstanceOf(class: Collection::class)
        ->toHaveCount(count: 1)
        ->first()->toBeInstanceOf(class: Customer::class)
        ->first()->is($customer);
});
