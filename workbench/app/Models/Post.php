<?php

declare(strict_types=1);

namespace Workbench\App\Models;

use Illuminate\Database\Eloquent\Model;
use RedExplosion\Sqids\Concerns\HasSqids;

class Post extends Model
{
    use HasSqids;

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
