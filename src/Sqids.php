<?php

declare(strict_types=1);

namespace RedExplosion\Sqids;

use Sqids\Sqids as SqidsCore;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Sqids
{
    public static function forModel(Model $model): string
    {
        /** @var int $id */
        $id = $model->getKey();

        $prefix = static::prefixForModel(model: $model::class);
        $separator = $prefix ? Config::separator() : null;
        $sqid = static::encodeId(id: $id);

        return "{$prefix}{$separator}{$sqid}";
    }

    public static function prefixForModel(string $model): ?string
    {
        $classBasename = class_basename(class: $model);
        $prefixLength = Config::prefixLength();

        if (!$prefixLength) {
            return null;
        }

        $prefix = $prefixLength < 0
            ? $classBasename
            : rtrim(mb_strimwidth(string: $classBasename, start: 0, width: $prefixLength, encoding: 'UTF-8'));

        return match (Config::prefixCase()) {
            'upper' => Str::upper(value: $prefix),
            'camel' => Str::camel(value: $prefix),
            'snake' => Str::snake(value: $prefix),
            'kebab' => Str::kebab(value: $prefix),
            'title' => Str::title(value: $prefix),
            'studly' => Str::studly(value: $prefix),
            default => Str::lower(value: $prefix),
        };
    }

    public static function encodeId(int $id): string
    {
        return static::encoder()->encode(numbers: [$id]);
    }

    public static function decodeId(string $id): array
    {
        return static::encoder()->decode(id: $id);
    }

    public static function encoder(): SqidsCore
    {
        return new SqidsCore(
            alphabet: Config::alphabet(),
            minLength: Config::minLength(),
            blocklist: Config::blacklist(),
        );
    }
}
