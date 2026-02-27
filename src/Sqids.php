<?php

declare(strict_types=1);

namespace RedExplosion\Sqids;

use Illuminate\Database\Eloquent\Model;
use RedExplosion\Sqids\Support\Config;
use Sqids\Sqids as SqidsCore;

class Sqids
{
    public static function forModel(Model $model): ?string
    {
        /** @var int|null $id */
        $id = $model->getKey();

        if ($id === null) {
            return null;
        }

        $prefix = static::prefixForModel($model::class);
        $separator = $prefix ? Config::separator() : null;
        $sqid = static::encodeId($model::class, $id);

        return "{$prefix}{$separator}{$sqid}";
    }

    /**
     * @param  class-string<Model>  $model
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

        if (! $prefixClass) {
            return null;
        }

        return $prefixClass->prefix($model);
    }

    public static function encodeId(string $model, int $id): string
    {
        return static::encoder($model)->encode([$id]);
    }

    /**
     * @return array<int, int>
     */
    public static function decodeId(string $model, string $id): array
    {
        $decodedIds = static::encoder($model)->decode($id);

        if (empty($decodedIds)) {
            return [];
        }

        $decodedId = $decodedIds[0];
        $encodedId = static::encodeId($model, $decodedId);

        if ($id !== $encodedId) {
            return [];
        }

        return $decodedIds;
    }

    public static function encoder(string $model): SqidsCore
    {
        $model = mb_strtolower(class_basename($model));

        return new SqidsCore(
            static::alphabetForModel($model),
            Config::minLength(),
            Config::blacklist(),
        );
    }

    public static function alphabetForModel(string $model): string
    {
        $alphabet = Config::alphabet();
        $shuffle = $model . Config::shuffleKey();
        $shuffleLength = mb_strlen($shuffle);

        if (! $shuffleLength) {
            return Config::alphabet();
        }

        $alphabetArray = static::multiByteSplit(Config::alphabet());
        $shuffleArray = static::multiByteSplit($shuffle);

        for ($i = mb_strlen($alphabet) - 1, $v = 0, $p = 0; $i > 0; $i--, $v++) {
            $v %= $shuffleLength;
            $p += $int = mb_ord($shuffleArray[$v], 'UTF-8');
            $j = ($int + $v + $p) % $i;

            $temp = $alphabetArray[$j];
            $alphabetArray[$j] = $alphabetArray[$i];
            $alphabetArray[$i] = $temp;
        }

        return implode('', $alphabetArray);
    }

    /**
     * @return array<int, string>
     */
    protected static function multiByteSplit(string $string): array
    {
        return preg_split('/(?!^)(?=.)/u', $string) ?: [];
    }
}
