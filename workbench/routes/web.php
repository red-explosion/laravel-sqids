<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Workbench\App\Models\Charge;
use Workbench\App\Models\Customer;
use Workbench\App\Models\Post;

Route::get('customers/username/{customer:username}', fn (Customer $customer) => $customer->username);
Route::get('customers/{customer}', fn (Customer $customer) => $customer->name);
Route::get('customers/{customer}/{charge}', fn (Customer $customer, Charge $charge) => $charge->sqid)->scopeBindings();

Route::get('posts/{post}', fn (Post $post) => $post->title);
