<?php

declare(strict_types=1);

namespace RedExplosion\Sqids\Mixins;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/** @mixin Builder */
class WhereSqidInMixin
{
    public function whereSqidIn(): Closure
    {
        return function (array $sqids, $boolean = 'and', $not = false) {
            /** @var Model $model */
            $model = $this->getModel();

            $column = $model->qualifyColumn(column: $model->getKeyName());

            /** @phpstan-ignore-next-line */
            $values = array_map(callback: fn(string $sqid) => $this->getModel()->keyFromSqid(sqid: $sqid), array: $sqids);

            return $this->whereIn(column: $column, values: $values, boolean: $boolean, not: $not);
        };
    }
}
