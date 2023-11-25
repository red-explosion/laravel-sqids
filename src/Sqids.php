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
        $separator = config(key: 'sqids.separator');

        if (!is_string(value: $separator)) {
            $separator = '_';
        }

        $sqid = static::encodeId(id: $id);

        return "{$prefix}{$separator}{$sqid}";
    }

    public static function prefixForModel(Model $model): ?string
    {
        $classBasename = class_basename(class: $model);
        $prefixLength = config(key: 'sqids.prefix.length') ?? 3;

        if (!is_int(value: $prefixLength)) {
            $prefixLength = 3;
        }

        $prefix = $prefixLength < 0
            ? $classBasename
            : rtrim(mb_strimwidth(string: $classBasename, start: 0, width: $prefixLength, encoding: 'UTF-8'));

        return match (config(key: 'sqids.prefix.case')) {
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

    public static function decodeId(string $id): int
    {
        return static::encoder()->decode(id: $id)[0];
    }

    public static function encoder(): SqidsCore
    {
        $alphabet = config(key: 'sqids.alphabet') ?? '';
        $minLength = config(key: 'sqids.length') ?? 10;
        $blacklist = config(key: 'sqids.blacklist') ?? [];

        if (!is_array($blacklist)) {
            $blacklist = [];
        }

        return new SqidsCore(
            alphabet: is_string(value: $alphabet) ? $alphabet : '',
            minLength: is_int($minLength) ? $minLength : 10,
            blocklist: array_merge(SqidsCore::DEFAULT_BLOCKLIST, $blacklist),
        );
    }
}
