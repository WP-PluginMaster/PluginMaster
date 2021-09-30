<?php


namespace PluginMaster\Bootstrap\System\Helpers;

use PluginMaster\Bootstrap\System\Application;
use PluginMaster\Foundation\View\ViewHandler;


class App
{

    /**
     * @var ViewHandler
     */
    protected static $viewHandler;

    /**
     * @return mixed|string
     */
    public static function basePath() {
        return static::get()->basePath();
    }

    /**
     * @param null $class
     * @return Application|null
     */
    public static function get( $class = null ) {
        if ( is_null( $class ) ) {
            return Application::getInstance();
        }

        return Application::getInstance()->get( $class );
    }

    /**
     * access only config/app.php 's config data
     * no need to pass app just like: config('slug') for app slug name
     * @param $key
     * @return Application|null
     */
    public static function config( $key ) {
        return static::get()->config( $key );
    }

    /**
     * @return mixed|string
     */
    public static function baseUrl() {
        return static::get()->baseUrl();
    }

    /**
     * @return mixed|string
     */
    public static function textDomain() {
        return static::get()->config( 'slug' );
    }

    /**
     * @param $path
     * @param $data
     * @return string
     */
    public static function view( $path, $data = [] ) {
        return static::resolveViewFile( $path, $data );
    }

    /**
     * @param $path
     * @param array $data
     * @return mixed
     */
    private static function resolveViewFile( $path, $data = [] ) {

        if ( !static::$viewHandler ) {
            $app = static::get();

            $options = $app->config( 'twig_template' ) ? [ 'cache_path' => $app->cachePath( 'views' ), 'text_domain' => $app->config( 'slug' ) ] : [] ;

            static::$viewHandler = $app->get( ViewHandler::class )->setConfig( $app->viewPath( 'views' ), $options );
        }

        return static::$viewHandler->render( $path, $data );

    }

}
