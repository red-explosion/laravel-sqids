<?php

declare(strict_types=1);

namespace RedExplosion\Sqids\Concerns;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Str;
use RedExplosion\Sqids\Sqids;
use RedExplosion\Sqids\Support\Config;

trait HasSqids
{
    protected function initializeHasSqids(): void
    {
        $this->append(['sqid']);
    }

    public function getSqidAttribute(): ?string
    {
        return Sqids::forModel($this);
    }

    public function getSqidPrefix(): ?string
    {
        return $this->sqidPrefix ?? null;
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
     */
    public function resolveRouteBindingQuery($query, $value, $field = null): Builder
    {
        if ($field && $field !== 'sqid') {
            return parent::resolveRouteBindingQuery($query, $value, $field);
        }

        if (! $field && $this->getRouteKeyName() !== 'sqid') {
            return parent::resolveRouteBindingQuery($query, $value, $field);
        }

        return $query->whereSqid($value);
    }

    public static function keyFromSqid(string $sqid): ?int
    {
        $sqid = Str::afterLast($sqid, Config::separator());

        $length = Str::length($sqid);

        if ($length < Config::minLength()) {
            return null;
        }

        return Sqids::decodeId(__CLASS__, $sqid)[0] ?? null;
    }
}
