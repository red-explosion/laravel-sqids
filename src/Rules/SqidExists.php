<?php

declare(strict_types=1);

namespace RedExplosion\Sqids\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @template TModel of EloquentModel
 */
class SqidExists implements ValidationRule
{
    /**
     * @var class-string<TModel>
     */
    protected string $modelClass;

    /**
     * @var array<int, Closure(Builder<TModel>): void>
     */
    protected array $constraints = [];

    /**
     * @param  class-string<TModel>  $modelClass
     */
    public function __construct(string $modelClass)
    {
        $this->modelClass = $modelClass;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! is_string($value) || $value === '') {
            $fail('validation.exists')->translate();

            return;
        }

        /** @var TModel $model */
        $model = new $this->modelClass;

        // @phpstan-ignore-next-line
        $query = $model
            ->newQueryWithoutScopes()
            ->whereSqid($value);

        foreach ($this->constraints as $constraint) {
            $constraint($query);
        }

        if ($query->exists()) {
            return;
        }

        $fail('validation.exists')->translate();
    }

    public function where(string $column, mixed $value = null): static
    {
        $this->constraints[] = function (Builder $query) use ($column, $value): void {
            $query->where($column, $value);
        };

        return $this;
    }

    public function whereNot(string $column, mixed $value): static
    {
        $this->constraints[] = function (Builder $query) use ($column, $value): void {
            $query->where($column, '!=', $value);
        };

        return $this;
    }

    public function whereNull(string $column): static
    {
        $this->constraints[] = function (Builder $query) use ($column): void {
            $query->whereNull($column);
        };

        return $this;
    }

    public function whereNotNull(string $column): static
    {
        $this->constraints[] = function (Builder $query) use ($column): void {
            $query->whereNotNull($column);
        };

        return $this;
    }

    /**
     * @param  array<int, mixed>  $values
     */
    public function whereIn(string $column, array $values): static
    {
        $this->constraints[] = function (Builder $query) use ($column, $values): void {
            $query->whereIn($column, $values);
        };

        return $this;
    }

    /**
     * @param  array<int, mixed>  $values
     */
    public function whereNotIn(string $column, array $values): static
    {
        $this->constraints[] = function (Builder $query) use ($column, $values): void {
            $query->whereNotIn($column, $values);
        };

        return $this;
    }

    public function withoutTrashed(): static
    {
        return $this->whereNull($this->getDeletedAtColumn());
    }

    public function onlyTrashed(): static
    {
        return $this->whereNotNull($this->getDeletedAtColumn());
    }

    protected function getDeletedAtColumn(): string
    {
        $column = 'deleted_at';

        $model = new $this->modelClass;

        // @phpstan-ignore-next-line
        if (is_subclass_of($model, SoftDeletes::class)) {
            $column = $model->getQualifiedDeletedAtColumn();
        }

        return $column;
    }
}
