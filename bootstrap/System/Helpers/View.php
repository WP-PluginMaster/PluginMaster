<?php


namespace UIDons\Bootstrap\System\Helpers;

use PluginMaster\Bootstrap\System\Helpers\App;
use PluginMaster\Foundation\View\ViewHandler;


class View
{

    /**
     * @var ViewHandler
     */
    protected static $viewHandler;


    /**
     * @param $path
     * @param  array  $data
     * @param  bool  $avoidTemplate
     * @return string
     */
    public static function render($path, $data = [], $avoidTemplate = false)
    {
        return static::resolveView()->render($path, $data, $avoidTemplate);
    }

    /**
     * @return mixed
     */
    private static function resolveView()
    {
        if (!static::$viewHandler) {
            $app = App::get();
            $options['template'] = $app->config('template_engine') ;
            $options['text_domain'] = $app->config('slug') ;
            $options['cache_path'] = $app->cachePath('views');

            static::$viewHandler = new ViewHandler( $app->viewPath(),  $options ) ;
        }

        return static::$viewHandler;
    }


}
