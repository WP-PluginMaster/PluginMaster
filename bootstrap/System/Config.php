<?php

namespace PluginMaster\Bootstrap\System;

use PluginMaster\Bootstrap\System\Helpers\App;
use PluginMaster\Contracts\Config\ConfigInterface;
use PluginMaster\Foundation\Config\ConfigHandler;

class Config implements ConfigInterface
{

    protected static $instance;

    /**
     * @param $key
     *
     * @return mixed
     */
    public static function get( $key ) {
        return static::getInstance()->resolveData( $key );
    }

    /**
     * @return ConfigHandler
     */
    private static function getInstance() {
        if ( !self::$instance ) {
            self::$instance = App::get( ConfigHandler::class );
        }

        return self::$instance;
    }

    /**
     * @param $key
     * @return mixed
     */
    public static function set( $key ) {
    }


}
