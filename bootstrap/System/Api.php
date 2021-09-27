<?php


namespace PluginMaster\Bootstrap\System;


use PluginMaster\Bootstrap\System\Helpers\App;
use PluginMaster\Contracts\Api\ApiInterface;
use PluginMaster\Foundation\Api\ApiHandler;

class Api implements ApiInterface
{
    /**
     * @var string
     */
    public static $prefix;

    /**
     * @var string
     */
    private static $middleware;


    private static $apiHandler;


    /**
     * setting up api prefix and middleware as array with  $config
     * @param $config
     * @param $callback
     */
    public static function group( $config, $callback ) {

        static::$prefix     = isset( $config['prefix'] ) ? '/' . $config['prefix'] : null;
        static::$middleware = $config['middleware'] ?? null;

        if ( gettype( $callback ) == 'object' ) {

            call_user_func( $callback );

            // reset prefix and middleware
            static::$prefix     = null;
            static::$middleware = null;
        }
    }

    /**
     * @param $prefix
     * @param $callback
     */
    public static function prefix( $prefix, $callback ) {

        static::$prefix     =   '/' . $prefix;

        if ( gettype( $callback ) == 'object' ) {

            call_user_func( $callback );

            // reset prefix
            static::$prefix = null;
        }
    }

    /**
     * @param $middlewareName
     * @param $callback
     */
    public static function middleware( $middlewareName, $callback ) {

        static::$middleware =  $middlewareName  ;

        if ( gettype( $callback ) == 'object' ) {

            call_user_func( $callback );

            // reset middleware
            static::$middleware = null;
        }
    }

    /**
     * @param $route
     * @param $callback
     * @param bool $public
     */
    public static function get( $route, $callback, $public = false ) {
        static::registerAPI( [ $route, 'GET', $callback, $public ] );
    }

    /**
     * @param $api
     * @param bool $dynamic
     */
    private static function registerAPI( $api, $dynamic = false ) {
        $api[] = static::$prefix;
        $api[] = static::$middleware;
        $api[] = $dynamic;

        if ( !static::$apiHandler ) static::$apiHandler = App::get( ApiHandler::class );

        static::$apiHandler->register( $api, $dynamic );
    }

    /**
     * @param $route
     * @param $callback
     * @param bool $public
     */
    public static function post( $route, $callback, $public = false ) {
        static::registerAPI( [ $route, 'POST', $callback, $public ] );
    }

    /**
     * @param $route
     * @param $callback
     * @param bool $public
     */
    public static function put( $route, $callback, $public = false ) {
        static::registerAPI( [ $route, 'PUT', $callback, $public ] );
    }

    /**
     * @param $route
     * @param $callback
     * @param bool $public
     */
    public static function patch( $route, $callback, $public = false ) {
        static::registerAPI( [ $route, 'PATCH', $callback, $public ] );
    }

    /**
     * @param $route
     * @param $callback
     * @param bool $public
     */
    public static function delete( $route, $callback, $public = false ) {
        static::registerAPI( [ $route, 'DELETE', $callback, $public ] );
    }

    /**
     * @param $route
     * @param $callback
     * @param bool $public
     */
    public static function all( $route, $callback, $public = false ) {
        static::registerAPI( [ $route, 'GET, POST, PUT, PATCH, DELETE', $callback, $public ] );
    }

    /**
     * @param $route
     * @param $class
     * @param bool $public
     */
    public static function dynamic( $route, $class, $public = false ) {
        static::registerAPI( [ $route, 'GET, POST, PUT, PATCH, DELETE', $class, $public ], true );
    }


}
