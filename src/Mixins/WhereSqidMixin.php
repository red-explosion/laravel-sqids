<?php

declare(strict_types=1);

namespace RedExplosion\Sqids\Mixins;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use RedExplosion\Sqids\Sqids;

/** @mixin Builder */
class WhereSqidMixin
{
    public function whereSqid(): Closure
    {
        return fn($id) => $this->whereKey(id: Sqids::decodeId(id: $id));
    }
}
