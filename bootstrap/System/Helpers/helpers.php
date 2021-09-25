<?php

use PluginMaster\Bootstrap\System\Application;
use PluginMaster\Bootstrap\System\Config;


if ( !function_exists( 'plugin_master_app' ) ) {

    /**
     * Get the available container instance.
     * @param null $class
     * @return \DI\T|mixed|object|Application
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     */

    function plugin_master_app($class = null) {
        if ( is_null( $class ) ) {
            return Application::getInstance();
        }

        return Application::getInstance()->get( $class );
    }

}


if ( !function_exists( 'plugin_master_config' ) ) {

    /**
     * Get config.
     * @param $key
     * @return mixed
     */

    function plugin_master_config( $key ) {
        return Config::get($key);
    }


}


if ( !function_exists( 'plugin_master_url' ) ) {

    /**
     * Get config.
     * @param $key
     * @return mixed
     */

    function plugin_master_url() {
        return Application::getInstance()->baseUrl();
    }


}
