<?php

declare(strict_types=1);

namespace Workbench\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use RedExplosion\Sqids\Concerns\HasSqids;

class Post extends Model
{
    use HasSqids;
    use SoftDeletes;

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
