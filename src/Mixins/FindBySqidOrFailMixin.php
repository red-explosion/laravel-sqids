<?php

declare(strict_types=1);

namespace RedExplosion\Sqids\Mixins;

use Closure;
use Illuminate\Database\Eloquent\Builder;

/** @mixin Builder */
class FindBySqidOrFailMixin
{
    public function findBySqidOrFail(): Closure
    {
        /** @phpstan-ignore-next-line */
        return fn (string $sqid, array $columns = ['*']) => $this->findOrFail($this->getModel()->keyFromSqid($sqid), $columns);
    }
}
