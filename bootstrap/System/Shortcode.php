<?php

namespace PluginMaster\Bootstrap\System;

use PluginMaster\Bootstrap\System\Helpers\App;
use PluginMaster\Contracts\Shortcode\ShortcodeInterface;
use PluginMaster\Foundation\Shortcode\ShortcodeHandler;

class Shortcode implements ShortcodeInterface
{

    /**
     * @var ShortcodeHandler
     */
    private static ShortcodeHandler $shortcodeHandler;


    /**
     * @param string $name
     * @param mixed $callback
     */
    public static function add(string $name, $callback)
    {
        static::handler()->add($name, $callback);
    }

    private static function handler(): ShortcodeHandler
    {
        if (!static::$shortcodeHandler) {
            static::$shortcodeHandler = App::get(ShortcodeHandler::class);
        }

        return static::$shortcodeHandler;
    }
}
