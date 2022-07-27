<?php

namespace PluginMaster\Bootstrap\System;

use PluginMaster\Bootstrap\System\Helpers\App;
use PluginMaster\Contracts\Cache\CacheInterface;
use PluginMaster\Foundation\Cache\CacheHandler;

class Cache implements CacheInterface
{

    protected static $cacheHandlerInstance;

    /**
     * @param $fileName
     * @param $directory
     * @return mixed
     */
    public static function get($fileName, $directory = null)
    {
        return static::getHandler()->get($fileName, $directory);
    }


    private static function getHandler()
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
     * @param $fileName
     * @param $content
     * @param $directory
     * @return mixed
     */
    public static function set($fileName, $content, $directory = null)
    {
        return static::getHandler()->createFile($fileName, $content, $directory);
    }

    /**
     * @param $fileName
     * @param $content
     * @param $directory
     * @return mixed
     */
    public static function reset()
    {
        return static::getHandler()->reset();
    }


    /**
     * @param $fileName
     * @param  null  $directory
     * @return mixed
     */
    public static function check($fileName, $directory = null)
    {
        return static::getHandler()->check($fileName, $directory);
    }

}
