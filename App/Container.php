<?php

namespace App;

class Container
{
    private static array $binds = [];
    private static array $singletons = [];

    /**
     * Assigns a class to be resolved as another or as a callable.
     */
    public static function bind(string $class, string|callable $resolve): void
    {
        self::$binds[$class] = ['resolve' => $resolve, 'singleton' => false];
    }

    /**
     * Assigns a class to be used as a singleton.
     */
    public static function singleton(string $class): void
    {
        self::$binds[$class] = ['resolve' => $class, 'singleton' => true];
    }

    /**
     * Resolves the class by checking if it is assigned to a bind or is a singleton.
     */
    public static function make(string $class)
    {
        $resolve = $class;
        $singleton = false;

        if (isset(self::$binds[$class])) {
            $resolve = self::$binds[$class]['resolve'];
            $singleton = self::$binds[$class]['singleton'];
        }

        if ($singleton) {
            return self::resolveSingleton($resolve);
        }

        return self::resolve($resolve);
    }

    /**
     * Return the current instance or create and save a new one
     */
    public static function resolveSingleton(string $class)
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

    /**
     * Return a new class instance or the result of the callable
     */
    public static function resolve(string|callable $arg)
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
