<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Validator;
use RedExplosion\Sqids\Rules\SqidExists;
use RedExplosion\Sqids\Sqids;
use Workbench\App\Models\Customer;
use Workbench\Database\Factories\CustomerFactory;
use Workbench\Database\Factories\PostFactory;

it('passes when the sqid exists', function (): void {
    $customer = CustomerFactory::new()->create();

    $validator = Validator::make(
        ['customer' => $customer->sqid],
        ['customer' => [new SqidExists(Customer::class)]],
    );

    expect($validator->passes())->toBeTrue();
});

it('fails when the sqid is invalid', function (): void {
    $validator = Validator::make(
        ['customer' => 'invalid-sqid'],
        ['customer' => [new SqidExists(Customer::class)]],
    );

    expect($validator->fails())->toBeTrue();
});

it('fails when the sqid decodes to a missing model', function (): void {
    $validator = Validator::make(
        ['customer' => Sqids::encodeId(Customer::class, 999_999)],
        ['customer' => [new SqidExists(Customer::class)]],
    );

    expect($validator->fails())->toBeTrue();
});

it('fails for non scalar values', function (): void {
    $validator = Validator::make(
        ['customer' => ['not-a-scalar']],
        ['customer' => [new SqidExists(Customer::class)]],
    );

    expect($validator->fails())->toBeTrue();
});

it('supports where constraints', function (): void {
    $customer = CustomerFactory::new()->create([
        'username' => 'allowed-user',
    ]);

    $passes = Validator::make(
        ['customer' => $customer->sqid],
        ['customer' => [(new SqidExists(Customer::class))->where('username', 'allowed-user')]],
    )->passes();

    $fails = Validator::make(
        ['customer' => $customer->sqid],
        ['customer' => [(new SqidExists(Customer::class))->where('username', 'blocked-user')]],
    )->fails();

    expect($passes)->toBeTrue()
        ->and($fails)->toBeTrue();
});

it('supports whereNot constraints', function (): void {
    $customer = CustomerFactory::new()->create([
        'username' => 'allowed-user',
    ]);

    $passes = Validator::make(
        ['customer' => $customer->sqid],
        ['customer' => [(new SqidExists(Customer::class))->whereNot('username', 'blocked-user')]],
    )->passes();

    $fails = Validator::make(
        ['customer' => $customer->sqid],
        ['customer' => [(new SqidExists(Customer::class))->whereNot('username', 'allowed-user')]],
    )->fails();

    expect($passes)->toBeTrue()
        ->and($fails)->toBeTrue();
});

it('supports whereIn and whereNotIn constraints', function (): void {
    $customer = CustomerFactory::new()->create([
        'username' => 'allowed-user',
    ]);

    $whereInPasses = Validator::make(
        ['customer' => $customer->sqid],
        ['customer' => [(new SqidExists(Customer::class))->whereIn('username', ['allowed-user'])]],
    )->passes();

    $whereInFails = Validator::make(
        ['customer' => $customer->sqid],
        ['customer' => [(new SqidExists(Customer::class))->whereIn('username', ['blocked-user'])]],
    )->fails();

    $whereNotInPasses = Validator::make(
        ['customer' => $customer->sqid],
        ['customer' => [(new SqidExists(Customer::class))->whereNotIn('username', ['blocked-user'])]],
    )->passes();

    $whereNotInFails = Validator::make(
        ['customer' => $customer->sqid],
        ['customer' => [(new SqidExists(Customer::class))->whereNotIn('username', ['allowed-user'])]],
    )->fails();

    expect($whereInPasses)->toBeTrue()
        ->and($whereInFails)->toBeTrue()
        ->and($whereNotInPasses)->toBeTrue()
        ->and($whereNotInFails)->toBeTrue();
});

it('supports whereNull and whereNotNull constraints', function (): void {
    $activePost = PostFactory::new()->create();
    $trashedPost = PostFactory::new()->create();

    $trashedPost->delete();

    $whereNullPasses = Validator::make(
        ['post' => $activePost->sqid],
        ['post' => [(new SqidExists($activePost::class))->whereNull('deleted_at')]],
    )->passes();

    $whereNullFails = Validator::make(
        ['post' => $trashedPost->sqid],
        ['post' => [(new SqidExists($trashedPost::class))->whereNull('deleted_at')]],
    )->fails();

    $whereNotNullPasses = Validator::make(
        ['post' => $trashedPost->sqid],
        ['post' => [(new SqidExists($trashedPost::class))->whereNotNull('deleted_at')]],
    )->passes();

    $whereNotNullFails = Validator::make(
        ['post' => $activePost->sqid],
        ['post' => [(new SqidExists($activePost::class))->whereNotNull('deleted_at')]],
    )->fails();

    expect($whereNullPasses)->toBeTrue()
        ->and($whereNullFails)->toBeTrue()
        ->and($whereNotNullPasses)->toBeTrue()
        ->and($whereNotNullFails)->toBeTrue();
});

it('supports withoutTrashed and onlyTrashed constraints', function (): void {
    $activePost = PostFactory::new()->create();
    $trashedPost = PostFactory::new()->create();

    $trashedPost->delete();

    $withoutTrashedPasses = Validator::make(
        ['post' => $activePost->sqid],
        ['post' => [(new SqidExists($activePost::class))->withoutTrashed()]],
    )->passes();

    $withoutTrashedFails = Validator::make(
        ['post' => $trashedPost->sqid],
        ['post' => [(new SqidExists($trashedPost::class))->withoutTrashed()]],
    )->fails();

    $onlyTrashedPasses = Validator::make(
        ['post' => $trashedPost->sqid],
        ['post' => [(new SqidExists($trashedPost::class))->onlyTrashed()]],
    )->passes();

    $onlyTrashedFails = Validator::make(
        ['post' => $activePost->sqid],
        ['post' => [(new SqidExists($activePost::class))->onlyTrashed()]],
    )->fails();

    expect($withoutTrashedPasses)->toBeTrue()
        ->and($withoutTrashedFails)->toBeTrue()
        ->and($onlyTrashedPasses)->toBeTrue()
        ->and($onlyTrashedFails)->toBeTrue();
});
