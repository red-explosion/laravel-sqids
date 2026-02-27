<?php

declare(strict_types=1);

namespace RedExplosion\Sqids\Mixins;

use Closure;
use Illuminate\Database\Eloquent\Builder;

/** @mixin Builder */
class FindBySqidMixin
{
    public function findBySqid(): Closure
    {
        /** @phpstan-ignore-next-line */
        return fn (string $sqid, array $columns = ['*']) => $this->find($this->getModel()->keyFromSqid($sqid), $columns);
    }
}
