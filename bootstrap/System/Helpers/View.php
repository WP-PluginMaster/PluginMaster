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
     * @param bool $avoidTemplate
     * @return string
     */
    public static function render( $path, $data = [], $avoidTemplate = false ) {
        return static::resolveView()->render( $path, $data, $avoidTemplate );
    }

    /**
     * @return mixed
     */
    private static function resolveView() {

        if ( !static::$viewHandler ) {
            $app = App::get();

            $options = $app->config( 'twig_template' ) ?
                [ 'cache_path' => $app->cachePath( 'views' ), 'text_domain' => $app->config( 'slug' ), 'auto_reload' => $app->config( 'twig_auto_reload' ) ?? false ]
                : [];
            static::$viewHandler = $app->get( ViewHandler::class )->setConfig( $app->viewPath(), $options );
        }

        return static::$viewHandler;

    }

}
