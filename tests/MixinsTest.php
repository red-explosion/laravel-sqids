<?php

declare(strict_types=1);

namespace RedExplosion\Sqids\Tests;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Workbench\App\Models\Customer;
use Workbench\Database\Factories\CustomerFactory;

it('can find a model by its sqid', function (): void {
    $customer = CustomerFactory::new()->create();

    expect(Customer::findBySqid(sqid: $customer->sqid))
        ->toBeInstanceOf(Customer::class)
        ->name->toBe($customer->name);
});

it('can find a model by its sqid or throw an exception', function (): void {
    $customer = CustomerFactory::new()->create();

    expect(Customer::findBySqidOrFail(sqid: $customer->sqid))
        ->toBeInstanceOf(Customer::class)
        ->name->toBe($customer->name);

    $this->expectException(ModelNotFoundException::class);

    Customer::findBySqidOrFail(sqid: 'invalid-sqid');
});

it('can get all models where sqid equals', function (): void {
    $customer = CustomerFactory::new()->create();

    CustomerFactory::new()->count(10)->create();

    expect(Customer::whereSqid($customer->sqid)->get())
        ->toBeInstanceOf(Collection::class)
        ->first()->toBeInstanceOf(Customer::class)
        ->first()->name->toBe($customer->name);
});

it('can get all models where sqid in', function (): void {
    $customer = CustomerFactory::new()->create();

    CustomerFactory::new()->count(10)->create();

    expect(Customer::whereSqidIn('id', [$customer->sqid])->get())
        ->toBeInstanceOf(Collection::class)
        ->toHaveCount(1)
        ->pluck('id')->toContain($customer->id)
        ->first()->toBeInstanceOf(Customer::class)
        ->first()->name->toBe($customer->name);
});

it('can get all models where sqid not in', function (): void {
    $customer = CustomerFactory::new()->create();

    CustomerFactory::new()->count(10)->create();

    expect(Customer::whereSqidNotIn('id', [$customer->sqid])->get())
        ->toBeInstanceOf(Collection::class)
        ->toHaveCount(10)
        ->pluck('id')->not->toContain($customer->id);
});
