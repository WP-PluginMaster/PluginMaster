<?php

namespace PluginMaster\Bootstrap\System;

use PluginMaster\Bootstrap\System\Helpers\App;
use PluginMaster\Foundation\Action\ActionHandler;

class Action
{

    /**
     * @var \PluginMaster\Foundation\Action\ActionHandler
     */
    private static ActionHandler $shortcodeHandler;


    /**
     * add any action and resolve callback
     * @param string $name
     * @param $callback
     * @param int $priority
     */
    public static function add(string $name, $callback, int $priority = 10): void
    {
        static::handler()->add($name, $callback, $priority);
    }

    private static function handler(): ActionHandler
    {
        if (!static::$shortcodeHandler) {
            static::$shortcodeHandler = App::get(ActionHandler::class);
        }

        return static::$shortcodeHandler;
    }

    /**
     * add only wp_ajax_ action and resolve callback
     * @note no need to pass 'wp_ajax_'
     * @param string $name
     * @param $callback
     * @param int $priority
     */
    public static function ajax(string $name, $callback, int $priority = 10): void
    {
        static::handler()->add('wp_ajax_' . $name, $callback, $priority);
    }
}
