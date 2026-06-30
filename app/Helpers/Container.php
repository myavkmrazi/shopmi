<?php

namespace App\Helpers;

class Container
{
    private static array $container = [];

    public static function set(string $key, $value): void
    {
        self::$container[$key] = $value;
    }

    public static function get(string $key, $default = null)
    {
        return self::$container[$key] ?? $default;
    }
}
