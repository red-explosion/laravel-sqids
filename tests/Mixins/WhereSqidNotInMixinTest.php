<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Collection;
use Workbench\App\Models\Customer;
use Workbench\Database\Factories\CustomerFactory;

it(description: 'can query all models except the given sqids', closure: function (): void {
    $customer = CustomerFactory::new()->create();

    CustomerFactory::new()->count(count: 10)->create();

    $customers = Customer::query()
        ->whereSqidNotIn(column: 'id', sqids: [$customer->sqid])
        ->get();

    expect($customers)
        ->toBeInstanceOf(class: Collection::class)
        ->toHaveCount(count: 10)
        ->pluck('id')->not->toContain($customer->id);
});
