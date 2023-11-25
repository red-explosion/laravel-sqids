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
        return fn(string $id, array $columns = ['*']) => $this->find(id: $this->getModel()->keyFromSqid(sqid: $id), columns: $columns);
    }
}
