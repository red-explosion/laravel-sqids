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

    protected static array $defaultBlacklist = [];

    protected static string $defaultSeparator = '_';

    protected static int $defaultPrefixLength = 3;

    protected static string $defaultPrefixCase = 'lower';

    public static function shuffleKey(): ?string
    {
        $shuffleKey = config(key: 'sqids.shuffle_key');

        if (!is_string($shuffleKey)) {
            return null;
        }

        return $shuffleKey;
    }

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

    public static function prefixClass(): ?Prefix
    {
        $prefix = config(key: 'sqids.prefix_class');

        if (!$prefix) {
            return null;
        }

        try {
            $prefix = new $prefix();
        } catch (Exception) {
            return new SimplePrefix();
        }

        if (!$prefix instanceof Prefix) {
            return new SimplePrefix();
        }

        return new $prefix();
    }
}
