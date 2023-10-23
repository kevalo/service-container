<?php

namespace App;

class Container
{
    private static array $binds = [];
    private static array $singletons = [];

    public static function bind(string $class, string|callable $returnClass, bool $singleton = false): void
    {
        self::$binds[$class] = ['class' => $returnClass, 'singleton' => $singleton];
    }

    public static function singleton(string $class): void
    {
        self::bind($class, $class, true);
    }

    public static function make(string $class)
    {
        $resolveClass = $class;
        $singleton = false;

        if (isset(self::$binds[$class])) {
            $resolveClass = self::$binds[$class]['class'];
            $singleton = self::$binds[$class]['singleton'];
        }

        if ($singleton) {
            return self::resolveSingleton($resolveClass);
        }

        return self::resolve($resolveClass);
    }

    private static function resolveSingleton(string $class)
    {
        if (isset(self::$singletons[$class])) {
            return self::$singletons[$class];
        }

        if (class_exists($class)) {
            $instance = new $class();
            self::$singletons[$class] = $instance;
            return $instance;
        }

        return null;
    }

    private static function resolve(string|callable $arg)
    {
        if (is_callable($arg)) {
            return $arg();
        }

        if (is_string($arg) && class_exists($arg)) {
            return new $arg();
        }

        return null;
    }
}
