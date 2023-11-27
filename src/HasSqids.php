<?php

declare(strict_types=1);

namespace RedExplosion\Sqids;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Str;

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

        return $this->whereSqid(sqid: $value);
    }

    public static function keyFromSqid(string $sqid): ?int
    {
        $prefixLength = Config::prefixLength();
        $prefix = Str::beforeLast(subject: $sqid, search: Config::separator());
        $expectedPrefix = Sqids::prefixForModel(model: __CLASS__);

        if ($prefixLength && $prefix !== $expectedPrefix) {
            return null;
        }

        $sqid = Str::afterLast(subject: $sqid, search: Config::separator());

        $length = Str::length(value: $sqid);

        if ($length < Config::minLength()) {
            return null;
        }

        return Sqids::decodeId(model: __CLASS__, id: $sqid)[0] ?? null;
    }
}
