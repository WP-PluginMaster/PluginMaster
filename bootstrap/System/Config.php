<?php

namespace PluginMaster\Bootstrap\System;

use PluginMaster\Bootstrap\System\Helpers\App;
use PluginMaster\Contracts\Config\ConfigInterface;
use PluginMaster\Foundation\Config\ConfigHandler;

class Config implements ConfigInterface
{

    /**
     * @var ConfigHandler
     */
    protected static $instance;

    /**
     * store accessed config with hashmap
     *
     * @var array
     */
    private static $accessedConfig;


    /**
     * @param $key
     *
     * @return mixed
     */
    public static function get($key)
    {
        if (isset(static::$accessedConfig[$key])) {
            return static::$accessedConfig[$key];
        }

        $data = static::getInstance()->resolveData($key);

        static::$accessedConfig[$key] = $data;

        return $data;
    }

    /**
     * @return ConfigHandler
     */
    private static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = App::get(ConfigHandler::class);
        }

        return self::$instance;
    }

    /**
     * @param $key
     * @return mixed
     */
    public static function set($key)
    {
    }


}
