<?php

declare(strict_types=1);

namespace RedExplosion\Sqids\Mixins;

use Closure;
use Illuminate\Database\Eloquent\Builder;

/** @mixin Builder */
class WhereSqidMixin
{
    public function whereSqid(): Closure
    {
        /** @phpstan-ignore-next-line */
        return fn(string $sqid) => $this->whereKey(id: $this->getModel()->keyFromSqid(sqid: $sqid));
    }
}
