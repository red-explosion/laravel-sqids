<?php

declare(strict_types=1);

namespace Workbench\App\Models;

use Illuminate\Database\Eloquent\Model;
use RedExplosion\Sqids\Concerns\HasSqids;

class Charge extends Model
{
    use HasSqids;

    protected string $sqidPrefix = 'ch';
}
