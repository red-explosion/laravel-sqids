<?php

declare(strict_types=1);

use Workbench\Database\Factories\CustomerFactory;
use Workbench\Database\Factories\PostFactory;

it('can bind a model from a sqid', function (): void {
    $customer = CustomerFactory::new()->create();

    $this
        ->get(uri: "/customers/{$customer->sqid}")
        ->assertContent(value: $customer->name);
});

it('can bind a model from a sqid without a prefix', function (): void {
    config()->set('sqids.prefix_class');

    $customer = CustomerFactory::new()->create();

    $this
        ->get(uri: "/customers/{$customer->sqid}")
        ->assertContent(value: $customer->name);
});

it('returns a 404 if the sqid is invalid', function (): void {
    $this
        ->get(uri: '/customers/invalid-sqid')
        ->assertNotFound();
});

it('can bind a model with a different key', function (): void {
    $customer = CustomerFactory::new()->create();

    $this
        ->get(uri: "/customers/username/{$customer->username}")
        ->assertContent(value: $customer->username);
});

it('can bind a model when the route key has been overridden', function (): void {
    $post = PostFactory::new()->create();

    $this
        ->get(uri: "/posts/{$post->slug}")
        ->assertContent(value: $post->title);
});
