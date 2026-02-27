<?php

declare(strict_types=1);

namespace RedExplosion\Sqids\Mixins;

use Closure;
use Illuminate\Database\Eloquent\Builder;

/** @mixin Builder */
class WhereSqidNotInMixin
{
    public function whereSqidNotIn(): Closure
    {
        return function (string $column, array $sqids, $boolean = 'and') {
            /** @phpstan-ignore-next-line  */
            return $this->whereSqidIn($column, $sqids, $boolean, not: true);
        };
    }
}
