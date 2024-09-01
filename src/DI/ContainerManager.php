<?php

namespace MiniRestFramework\DI;

class ContainerManager
{
    private static array $services = [];

    public static function set(string $name, $service): void
    {
        self::$services[$name] = $service;
    }

    public static function get(string $name)
    {
        if (!isset(self::$services[$name])) {
            throw new \RuntimeException("Service '{$name}' not found.");
        }
        return self::$services[$name];
    }

    public static function has(string $name): bool
    {
        return isset(self::$services[$name]);
    }
}