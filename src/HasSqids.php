<?php

declare(strict_types=1);

namespace RedExplosion\Sqids;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

trait HasSqids
{
    public function getSqidAttribute(): ?string
    {
        return Sqids::forModel(model: $this);
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'sqid';
    }

    /**
     * Retrieve the model for a bound value.
     *
     * @param  mixed  $value
     * @param  string|null  $field
     * @return Model|null
     */
    //    public function resolveRouteBinding($value, $field = null): ?Model
    //    {
    //        if ($field !== null) {
    //            return parent::resolveRouteBinding(value: $value, field: $field);
    //        }
    //
    //        return $this->findBySqid($value);
    //    }

    /**
     * Retrieve the model for a bound value.
     *
     * @param  Model|Relation  $query
     * @param  mixed  $value
     * @param  null  $field
     * @return Builder|Relation
     */
    public function resolveRouteBindingQuery($query, $value, $field = null): Builder|Relation
    {
        if ($field && $field !== $this->getRouteKeyName()) {
            return parent::resolveRouteBindingQuery(query: $query, value: $value, field: $field);
        }

        return $this->whereSqid($value);
    }
}
