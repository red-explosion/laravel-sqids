<?php

declare(strict_types=1);

namespace RedExplosion\Sqids\Mixins;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use RedExplosion\Sqids\Sqids;

/** @mixin Builder */
class FindBySqidMixin
{
    public function findBySqid(): Closure
    {
        return fn(string $id, array $columns = ['*']) => $this->find(id: Sqids::decodeId(id: $id), columns: $columns);
    }
}
