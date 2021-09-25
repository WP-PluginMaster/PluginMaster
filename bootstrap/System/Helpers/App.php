<?php


namespace PluginMaster\Bootstrap\System\Helpers;


use PluginMaster\Bootstrap\System\Application;

class App
{

    public static function root() {
        return static::get()->basePath();
    }

    public static function get( $class = null ) {
        if ( is_null( $class ) ) {
            return Application::getInstance();
        }

        return Application::getInstance()->get( $class );
    }

    public static function url() {
        return static::get()->baseUrl();
    }


}
