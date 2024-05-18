<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Workbench\App\Models\Customer;

Route::get(uri: 'customers/{customer}', action: fn (Customer $customer) => $customer->name);
