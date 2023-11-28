<?php

declare(strict_types=1);

namespace RedExplosion\Sqids\Support;

class Config
{
    protected static string $defaultAlphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

    protected static int $defaultMinLength = 10;

    protected static array $defaultBlacklist = [];

    protected static string $defaultSeparator = '_';

    protected static int $defaultPrefixLength = 3;

    protected static string $defaultPrefixCase = 'lower';

    public static function alphabet(): string
    {
        $alphabet = config(key: 'sqids.alphabet');

        if (!$alphabet || !is_string($alphabet)) {
            return static::$defaultAlphabet;
        }

        return $alphabet;
    }

    public static function minLength(): int
    {
        /** @var int|null $minLength */
        $minLength = config(key: 'sqids.min_length', default: static::$defaultMinLength);

        if (!$minLength || !is_int($minLength)) {
            return static::$defaultMinLength;
        }

        return $minLength;
    }

    public static function blacklist(): array
    {
        $blacklist = config(key: 'sqids.blacklist', default: static::$defaultBlacklist);

        if (!is_array($blacklist)) {
            return static::$defaultBlacklist;
        }

        return $blacklist;
    }

    public static function separator(): string
    {
        $separator = config(key: 'sqids.separator', default: static::$defaultSeparator);

        if (!$separator || !is_string(value: $separator)) {
            return static::$defaultSeparator;
        }

        return $separator;
    }

    public static function prefixLength(): int
    {
        /** @var int|null $prefixLength */
        $prefixLength = config(key: 'sqids.prefix.length', default: static::$defaultPrefixLength);

        if (!$prefixLength || !is_int($prefixLength)) {
            return static::$defaultPrefixLength;
        }

        return $prefixLength;
    }

    public static function prefixCase(): string
    {
        $prefixCase = config(key: 'sqids.prefix.case', default: static::$defaultPrefixCase);

        if (!$prefixCase || !is_string(value: $prefixCase)) {
            return static::$defaultPrefixCase;
        }

        return $prefixCase;
    }
}
