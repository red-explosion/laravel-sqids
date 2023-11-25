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

        $prefix = static::prefixForModel(model: $model);
        $separator = '_';
        $sqid = static::encodeId(id: $id);

        return "{$prefix}{$separator}{$sqid}";
    }

    public static function prefixForModel(Model $model): ?string
    {
        $classBasename = class_basename(class: $model);
        $prefix = rtrim(mb_strimwidth(string: $classBasename, start: 0, width: 3, encoding: 'UTF-8'));

        return Str::lower(value: $prefix);
    }

    public static function encodeId(int $id): string
    {
        return static::encoder()->encode(numbers: [$id]);
    }

    public static function decodeId(string $id): int
    {
        return static::encoder()->decode(id: $id)[0];
    }

    public static function encoder(): SqidsCore
    {
        return new SqidsCore(minLength: 10);
    }
}
