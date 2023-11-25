<?php

declare(strict_types=1);

namespace RedExplosion\Sqids\Mixins;

use Closure;
use Illuminate\Database\Eloquent\Builder;

/** @mixin Builder */
class FindOrFailBySqidMixin
{
    public function findOrFailBySqid(): Closure
    {
        /** @phpstan-ignore-next-line */
        return fn(string $sqid, array $columns = ['*']) => $this->findOrFail(id: $this->getModel()->keyFromSqid(sqid: $sqid), columns: $columns);
    }
}
