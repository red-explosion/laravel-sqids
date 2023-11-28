<?php

declare(strict_types=1);

namespace RedExplosion\Sqids;

use Illuminate\Database\Eloquent\Model;
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

    /**
     * @param  class-string<Model>  $model
     * @return string
     */
    public static function prefixForModel(string $model): ?string
    {
        $prefixClass = Config::prefixClass();

        /** @var string|null $modelPrefix */
        /** @phpstan-ignore-next-line */
        $modelPrefix = (new $model())->getSqidPrefix();

        if ($modelPrefix) {
            return $modelPrefix;
        }

        if (!$prefixClass) {
            return null;
        }

        return $prefixClass->prefix(model: $model);
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
        $shuffle = $model . Config::shuffleKey();
        $shuffleLength = mb_strlen(string: $shuffle);

        if (!$shuffleLength) {
            return Config::alphabet();
        }

        $alphabetArray = static::multiByteSplit(string: Config::alphabet());
        $shuffleArray = static::multiByteSplit(string: $shuffle);

        for ($i = mb_strlen($alphabet) - 1, $v = 0, $p = 0; $i > 0; $i--, $v++) {
            $v %= $shuffleLength;
            $p += $int = mb_ord($shuffleArray[$v], 'UTF-8');
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
