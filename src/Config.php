<?php

declare(strict_types=1);

namespace RedExplosion\Sqids;

class Config
{
    public static function string(string $key, string $default): string
    {
        $value = config(key: $key, default: $default);

        if (!is_string($value)) {
            return $default;
        }

        return $value;
    }

    public static function integer(string $key, int $default): int
    {
        $value = config(key: $key, default: $default);

        if (!is_int($value)) {
            return $default;
        }

        return $value;
    }

    public static function array(string $key, array $default = []): array
    {
        $value = config(key: $key, default: $default);

        if (!is_array($value)) {
            return $default;
        }

        return $value;
    }
}
