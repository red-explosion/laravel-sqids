<?php

declare(strict_types=1);

namespace Workbench\App\Models;

use Illuminate\Database\Eloquent\Model;
use RedExplosion\Sqids\HasSqids;

class Customer extends Model
{
    use HasSqids;
}
