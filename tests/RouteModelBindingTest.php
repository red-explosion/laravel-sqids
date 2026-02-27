<?php

declare(strict_types=1);

use Workbench\Database\Factories\ChargeFactory;
use Workbench\Database\Factories\CustomerFactory;
use Workbench\Database\Factories\PostFactory;

it('can bind a model from a sqid', function (): void {
    $customer = CustomerFactory::new()->create();

    $this
        ->get("/customers/{$customer->sqid}")
        ->assertContent($customer->name);
});

it('can bind a model from a sqid without a prefix', function (): void {
    config()->set('sqids.prefix_class');

    $customer = CustomerFactory::new()->create();

    $this
        ->get("/customers/{$customer->sqid}")
        ->assertContent($customer->name);
});

it('returns a 404 if the sqid is invalid', function (): void {
    $this
        ->get('/customers/invalid-sqid')
        ->assertNotFound();
});

it('can bind a model with a different key', function (): void {
    $customer = CustomerFactory::new()->create();

    $this
        ->get("/customers/username/{$customer->username}")
        ->assertContent($customer->username);
});

it('can bind a model when the route key has been overridden', function (): void {
    $post = PostFactory::new()->create();

    $this
        ->get("/posts/{$post->slug}")
        ->assertContent($post->title);
});

it('can scope route model bindings', function (): void {
    $customer = CustomerFactory::new()->create();
    $charge = ChargeFactory::new()->for($customer)->create();

    $this
        ->get("/customers/{$customer->sqid}/{$charge->sqid}")
        ->assertContent($charge->sqid);
});

it('returns a 404 if the child isn’t scoped to the parent', function (): void {
    $customer = CustomerFactory::new()->create();
    $charge = ChargeFactory::new()->create();

    $this
        ->get("/customers/{$customer->sqid}/{$charge->sqid}")
        ->assertNotFound();
});
