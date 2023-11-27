<?php

declare(strict_types=1);

namespace RedExplosion\Sqids;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use RedExplosion\Sqids\Support\Config;
use Sqids\Sqids as SqidsCore;

class Sqids
{
    public static function forModel(Model $model): string
    {
        /** @var int $id */
        $id = $model->getKey();

        $prefix = static::prefixForModel(model: $model::class);
        $separator = $prefix ? Config::separator() : null;
        $sqid = static::encodeId(model: $model::class, id: $id);

        return "{$prefix}{$separator}{$sqid}";
    }

    public static function prefixForModel(string $model): ?string
    {
        $classBasename = class_basename(class: $model);
        $prefixLength = Config::prefixLength();

        if (!$prefixLength) {
            return null;
        }

        /** @var string|null $modelPrefix */
        /** @phpstan-ignore-next-line */
        $modelPrefix = (new $model())->getSqidPrefix();

        if ($modelPrefix) {
            return $modelPrefix;
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

    public static function encodeId(string $model, int $id): string
    {
        return static::encoder(model: $model)->encode(numbers: [$id]);
    }

    public static function decodeId(string $model, string $id): array
    {
        return static::encoder(model: $model)->decode(id: $id);
    }

    public static function encoder(string $model): SqidsCore
    {
        $model = mb_strtolower(string: class_basename($model));

        return new SqidsCore(
            alphabet: static::alphabetForModel(model: $model),
            minLength: Config::minLength(),
            blocklist: Config::blacklist(),
        );
    }

    public static function alphabetForModel(string $model): string
    {
        $alphabet = Config::alphabet();
        $modelLength = mb_strlen(string: $model);

        if (!$modelLength) {
            return Config::alphabet();
        }

        $alphabetArray = static::multiByteSplit(string: Config::alphabet());
        $modelArray = static::multiByteSplit(string: $model);

        for ($i = mb_strlen($alphabet) - 1, $v = 0, $p = 0; $i > 0; $i--, $v++) {
            $v %= $modelLength;
            $p += $int = mb_ord($modelArray[$v], 'UTF-8');
            $j = ($int + $v + $p) % $i;

            $temp = $alphabetArray[$j];
            $alphabetArray[$j] = $alphabetArray[$i];
            $alphabetArray[$i] = $temp;
        }

        return implode(separator: '', array: $alphabetArray);
    }

    protected static function multiByteSplit(string $string): array
    {
        return preg_split(pattern: '/(?!^)(?=.)/u', subject: $string) ?: [];
    }
}
