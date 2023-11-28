<?php

declare(strict_types=1);

use Workbench\App\Models\Customer;
use Workbench\Database\Factories\ChargeFactory;
use Workbench\Database\Factories\CustomerFactory;

it('can get the sqid attribute', function (): void {
    $customer = CustomerFactory::new()->create();

    expect($customer->sqid)
        ->toBeString()
        ->toStartWith('cus_');
});

it('can get the sqid prefix', function (): void {
    $customer = CustomerFactory::new()->create();
    $charge = ChargeFactory::new()->create();

    expect($customer->getSqidPrefix())
        ->toBeNull()
        ->and($charge->getSqidPrefix())
        ->toBe('ch');
});

it('can get the key from the sqid', function (): void {
    $customer = CustomerFactory::new()->create();

    expect(Customer::keyFromSqid(sqid: $customer->sqid))
        ->toBe(1);
});
