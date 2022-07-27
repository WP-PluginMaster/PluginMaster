<?php


namespace PluginMaster\Bootstrap\System;


use PluginMaster\Bootstrap\System\Helpers\App;
use PluginMaster\Contracts\Shortcode\ShortcodeInterface;
use PluginMaster\Foundation\Shortcode\ShortcodeHandler;

class Shortcode implements ShortcodeInterface
{

    /**
     * @var object
     */
    private static object $shortcodeHandler;


    /**
     * @param $name
     * @param $callback
     */
    public static function add($name, $callback): void
    {
        static::handler()->add($name, $callback);
    }

    private static function handler(): object
    {
        if (!static::$shortcodeHandler) {
            static::$shortcodeHandler = App::get(ShortcodeHandler::class);
        }

        return static::$shortcodeHandler;
    }
}
