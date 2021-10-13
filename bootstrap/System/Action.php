<?php

namespace PluginMaster\Bootstrap\System;

use PluginMaster\Bootstrap\System\Helpers\App;
use PluginMaster\Foundation\Action\ActionHandler;

class Action
{

    /**
     * @var object
     */
    private static $shortcodeHandler;


    /**
     * add any action and resolve callback
     * @param $name
     * @param $callback
     * @param  int  $priority
     */
    public static function add($name, $callback, $priority = 10)
    {
        static::handler()->add($name, $callback, $priority);
    }

    private static function handler()
    {
        if (!static::$shortcodeHandler) {
            static::$shortcodeHandler = App::get(ActionHandler::class);
        }

        return static::$shortcodeHandler;
    }

    /**
     * add only wp_ajax_ action and resolve callback
     * @note no need to pass 'wp_ajax_'
     * @param $name
     * @param $callback
     * @param  int  $priority
     */
    public static function ajax($name, $callback, $priority = 10)
    {
        static::handler()->add('wp_ajax_'.$name, $callback, $priority);
    }
}
