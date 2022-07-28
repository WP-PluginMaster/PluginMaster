<?php

namespace PluginMaster\Bootstrap\System;

use PluginMaster\Bootstrap\System\Helpers\App;
use PluginMaster\Contracts\Cache\CacheInterface;
use PluginMaster\Foundation\Cache\CacheHandler;

class Cache implements CacheInterface
{

    protected static CacheHandler $cacheHandlerInstance;

    /**
     * @param string $fileName
     * @param string|null $directory
     * @return mixed
     */
    public static function get(string $fileName, string $directory = null)
    {
        return static::getHandler()->get($fileName, $directory);
    }

    /**
     * @return CacheHandler
     */
    private static function getHandler(): CacheHandler
    {
        if (!static::$cacheHandlerInstance) {
            $app = App::get();
            static::$cacheHandlerInstance = $app->get(CacheHandler::class)->setAppVersion(
                $app->version()
            )->setCachePath($app->cachePath());
        }

        return static::$cacheHandlerInstance;
    }

    /**
     * @param string $fileName
     * @param $content
     * @param null $directory
     * @return bool|int
     */
    public static function set(string $fileName, $content, $directory = null): bool
    {
        return static::getHandler()->createFile($fileName, $content, $directory);
    }

    /**
     * @return bool|int
     */
    public static function reset(): bool
    {
        return static::getHandler()->reset();
    }

    /**
     * @param string $fileName
     * @param string|null $directory
     * @return bool
     */
    public static function check(string $fileName, string $directory = null): bool
    {
        return static::getHandler()->check($fileName, $directory);
    }
}
