<?php

declare(strict_types=1);

namespace RedExplosion\Sqids\Mixins;

use Closure;
use Illuminate\Database\Eloquent\Builder;

/** @mixin Builder */
class WhereSqidInMixin
{
    public function whereSqidIn(): Closure
    {
        return function (string $column, array $sqids, $boolean = 'and', $not = false) {
            /** @phpstan-ignore-next-line */
            $values = array_map(fn (string $sqid) => $this->getModel()->keyFromSqid($sqid), $sqids);

            return $this->whereIn($column, $values, $boolean, $not);
        };
    }
}
