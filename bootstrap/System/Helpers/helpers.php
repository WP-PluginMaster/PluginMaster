<?php

use PluginMaster\Bootstrap\System\Application;
use PluginMaster\Bootstrap\System\Config;
use PluginMaster\Bootstrap\System\Helpers\App;
use PluginMaster\Bootstrap\System\Helpers\View;


if ( !function_exists( 'plugin_master_app' ) ) {

    /**
     * Get the available container instance.
     * @param null $class
     * @return object|Application
     */

    function plugin_master_app( $class = null ) {
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
        return Config::get( $key );
    }

}


if ( !function_exists( 'plugin_master_url' ) ) {

    /**
     * Get config.
     * @return mixed
     */

    function plugin_master_url() {
        return App::get()->baseUrl();
    }

}


if ( !function_exists( 'plugin_master_view' ) ) {

    /**
     * Get view file.
     * @param $path
     * @param array $data
     * @param bool $noTemplate
     * @return mixed
     */

    function plugin_master_view( $path, $data = [], $noTemplate = false ) {
        return View::render( $path , $data, $noTemplate);
    }

}


if ( !function_exists( 'plugin_master_domain' ) ) {

    /**
     * Get text domain / slug.
     */

    function plugin_master_domain() {
      return App::get()->config( 'slug' );
    }

}
