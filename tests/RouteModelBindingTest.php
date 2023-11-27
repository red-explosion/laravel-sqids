<?php

declare(strict_types=1);

use Workbench\Database\Factories\CustomerFactory;

it('can bind a model from a sqid', function (): void {
    $customer = CustomerFactory::new()->create();

    $this
        ->get(uri: "/customers/{$customer->sqid}")
        ->assertContent(value: $customer->name);
});

it('returns a 404 if the sqid is invalid', function (): void {
    $this
        ->get(uri: "/customers/invalid-sqid")
        ->assertNotFound();
});
