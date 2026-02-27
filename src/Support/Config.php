<?php

declare(strict_types=1);

namespace RedExplosion\Sqids\Support;

use Exception;
use RedExplosion\Sqids\Contracts\Prefix;
use RedExplosion\Sqids\Prefixes\SimplePrefix;

class Config
{
    protected static string $defaultAlphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

    protected static int $defaultMinLength = 10;

    /**
     * @var array<int, string>
     */
    protected static array $defaultBlacklist = [];

    protected static string $defaultSeparator = '_';

    protected static int $defaultPrefixLength = 3;

    protected static string $defaultPrefixCase = 'lower';

    public static function shuffleKey(): ?string
    {
        $shuffleKey = config('sqids.shuffle_key');

        if (! is_string($shuffleKey)) {
            return null;
        }

        return $shuffleKey;
    }

    public static function alphabet(): string
    {
        $alphabet = config('sqids.alphabet');

        if (! $alphabet || ! is_string($alphabet)) {
            return static::$defaultAlphabet;
        }

        return $alphabet;
    }

    public static function minLength(): int
    {
        /** @var int|null $minLength */
        $minLength = config('sqids.min_length', static::$defaultMinLength);

        if (! $minLength || ! is_int($minLength)) {
            return static::$defaultMinLength;
        }

        return $minLength;
    }

    /**
     * @return array<int, string>
     */
    public static function blacklist(): array
    {
        $blacklist = config('sqids.blacklist', static::$defaultBlacklist);

        if (! is_array($blacklist)) {
            return static::$defaultBlacklist;
        }

        return $blacklist;
    }

    public static function separator(): string
    {
        $separator = config('sqids.separator', static::$defaultSeparator);

        if (! $separator || ! is_string($separator)) {
            return static::$defaultSeparator;
        }

        return $separator;
    }

    public static function prefixClass(): ?Prefix
    {
        $prefix = config('sqids.prefix_class');

        if (! $prefix) {
            return null;
        }

        try {
            $prefix = new $prefix();
        } catch (Exception) {
            return new SimplePrefix();
        }

        if (! $prefix instanceof Prefix) {
            return new SimplePrefix();
        }

        return new $prefix();
    }
}
