<?php

declare(strict_types=1);

namespace RedExplosion\Sqids\Mixins;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use RedExplosion\Sqids\Sqids;

/** @mixin Builder */
class WhereSqidsInMixin
{
    public function whereSqidsIn(): Closure
    {
        return function (string $column, array $sqids, $boolean = 'and', $not = false) {
            $values = array_map(callback: fn(string $sqid) => Sqids::decodeId(id: $sqid), array: $sqids);

            return $this->whereIn(column: $column, values: $values, boolean: $boolean, not: $not);
        };
    }
}
