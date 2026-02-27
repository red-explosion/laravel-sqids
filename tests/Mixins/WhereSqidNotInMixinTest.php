<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Collection;
use Workbench\App\Models\Customer;
use Workbench\Database\Factories\CustomerFactory;

it('can query all models except the given sqids', function (): void {
    $customer = CustomerFactory::new()->create();

    CustomerFactory::new()->count(10)->create();

    $customers = Customer::query()
        ->whereSqidNotIn('id', [$customer->sqid])
        ->get();

    expect($customers)
        ->toBeInstanceOf(Collection::class)
        ->toHaveCount(10)
        ->pluck('id')->not->toContain($customer->id);
});
