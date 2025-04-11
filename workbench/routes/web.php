<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Workbench\App\Models\Charge;
use Workbench\App\Models\Customer;
use Workbench\App\Models\Post;

Route::get(uri: 'customers/username/{customer:username}', action: fn (Customer $customer) => $customer->username);
Route::get(uri: 'customers/{customer}', action: fn (Customer $customer) => $customer->name);
Route::get(uri: 'customers/{customer}/{charge}', action: fn (Customer $customer, Charge $charge) => $charge->sqid)->scopeBindings();

Route::get(uri: 'posts/{post}', action: fn (Post $post) => $post->title);
