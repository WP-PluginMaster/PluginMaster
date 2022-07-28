<?php


namespace PluginMaster\Bootstrap\System\Helpers;

use PluginMaster\Foundation\View\ViewHandler;


class View
{

    /**
     * @var ViewHandler
     */
    protected static $viewHandler;


    /**
     * @param $path
     * @param array $data
     * @param bool $noTemplate
     * @return string
     */
    public static function render( $path, $data = [], $noTemplate = false ) {
        return static::resolveView()->render( $path, $data, $noTemplate );
    }

    /**
     * @return mixed
     */
    private static function resolveView() {

        if ( !static::$viewHandler ) {
            $app = App::get();

            $options = $app->config( 'twig_template' ) ? [ 'cache_path' => $app->cachePath( 'views' ), 'text_domain' => $app->config( 'slug' ) ] : [];

            static::$viewHandler = $app->get( ViewHandler::class )->setConfig( $app->viewPath(), $options );
        }

        return static::$viewHandler;

    }

    /**
     * @param $path
     * @return void
     */
    public static function removeCache( $path = null ) {
        static::resolveView()->removeCache( $path );
    }

}
