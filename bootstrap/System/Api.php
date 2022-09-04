<?php


namespace PluginMaster\Bootstrap\System;


use PluginMaster\Bootstrap\System\Helpers\App;
use PluginMaster\Contracts\Api\ApiInterface;
use PluginMaster\Foundation\Api\ApiHandler;

class Api implements ApiInterface
{
    /**
     * @var string|null
     */
    public static ?string $prefix;

    /**
     * @var string
     */
    private static ?string $middleware = null;

    /**
     * @var ApiHandler|null
     */
    private static ?ApiHandler $apiHandler = null;

    /**
     * setting up api prefix and middleware as array with  $config
     * @param array $config
     * @param callable $callback
     */
    public static function group(array $config, callable $callback): void
    {
        static::$prefix = isset($config['prefix']) ? '/' . $config['prefix'] : null;
        static::$middleware = $config['middleware'] ?? null;

        if (gettype($callback) == 'object') {
            call_user_func($callback);

            // reset prefix and middleware
            static::$prefix = null;
            static::$middleware = null;
        }
    }

    /**
     * @param string $prefix
     * @param callable $callback
     */
    public static function prefix(string $prefix, callable $callback): void
    {
        static::$prefix = '/' . $prefix;

        if (gettype($callback) == 'object') {
            call_user_func($callback);

            // reset prefix
            static::$prefix = null;
        }
    }

    /**
     * @param string $middlewareName
     * @param callable $callback
     */
    public static function middleware(string $middlewareName, callable $callback): void
    {
        static::$middleware = $middlewareName;

        if (gettype($callback) == 'object') {
            call_user_func($callback);

            // reset middleware
            static::$middleware = null;
        }
    }

    /**
     * @param string $route
     * @param $callback
     * @param bool $public
     */
    public static function get(string $route, $callback, bool $public = false): void
    {
        static::registerAPI([$route, 'GET', $callback, $public]);
    }

    /**
     * @param array $api
     * @param bool $dynamic
     */
    private static function registerAPI(array $api, bool $dynamic = false): void
    {
        $api[] = static::$prefix;
        $api[] = static::$middleware;
        $api[] = $dynamic;

        if (!static::$apiHandler) {
            static::$apiHandler = App::get(ApiHandler::class);
        }

        static::$apiHandler->register($api, $dynamic);
    }

    /**
     * @param string $route
     * @param string|callable $callback
     * @param bool $public
     */
    public static function post(string $route, $callback, bool $public = false): void
    {
        static::registerAPI([$route, 'POST', $callback, $public]);
    }

    /**
     * @param string $route
     * @param string|callable $callback
     * @param bool $public
     */
    public static function put(string $route, $callback, bool $public = false): void
    {
        static::registerAPI([$route, 'PUT', $callback, $public]);
    }

    /**
     * @param string $route
     * @param string|callable $callback
     * @param bool $public
     */
    public static function patch(string $route, $callback, bool $public = false): void
    {
        static::registerAPI([$route, 'PATCH', $callback, $public]);
    }

    /**
     * @param string $route
     * @param string|callable $callback
     * @param bool $public
     */
    public static function delete(string $route, $callback, bool $public = false): void
    {
        static::registerAPI([$route, 'DELETE', $callback, $public]);
    }

    /**
     * @param string $route
     * @param string|callable $callback
     * @param bool $public
     */
    public static function all(string $route, $callback, bool $public = false): void
    {
        static::registerAPI([$route, 'GET, POST, PUT, PATCH, DELETE', $callback, $public]);
    }

    /**
     * @param string $route
     * @param string $class
     * @param bool $public
     */
    public static function dynamic(string $route, string $class, bool $public = false): void
    {
        static::registerAPI([$route, 'GET, POST, PUT, PATCH, DELETE', $class, $public], true);
    }
}
