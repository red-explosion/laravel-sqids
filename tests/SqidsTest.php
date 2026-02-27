<?php

declare(strict_types=1);

namespace RedExplosion\Sqids\Tests;

use RedExplosion\Sqids\Sqids;
use Workbench\App\Models\Customer;
use Workbench\Database\Factories\ChargeFactory;
use Workbench\Database\Factories\CustomerFactory;

it('can generate a sqid for a model', function (): void {
    $customer = CustomerFactory::new()->create();

    expect(Sqids::forModel($customer))
        ->toBeString()
        ->toStartWith('cst_');
});

it('can get the sqid prefix for a model', function (): void {
    $customer = CustomerFactory::new()->create();
    $charge = ChargeFactory::new()->create();

    expect($customer->getSqidPrefix())
        ->toBeNull()
        ->and(Sqids::prefixForModel($customer::class))
        ->toBe('cst')
        ->and($charge->getSqidPrefix())
        ->toBe('ch')
        ->and(Sqids::prefixForModel($charge::class))
        ->toBe('ch');
});

it('can encode an id and decode ids', function (): void {
    $sqid = Sqids::encodeId(Customer::class, 1);

    expect($sqid)
        ->toBeString()
        ->and(Sqids::decodeId(Customer::class, $sqid)[0])
        ->toBeInt()
        ->toBe(1);
});

it('validates a sqid when decoding', function (): void {
    $sqid = Sqids::encodeId(Customer::class, 1);

    expect(Sqids::decodeId(Customer::class, "Invalid{$sqid}"))->toBeEmpty();
});

it('can get the encoder instance', function (): void {
    expect(Sqids::encoder(Customer::class))->toBeInstanceOf(\Sqids\Sqids::class);
});
