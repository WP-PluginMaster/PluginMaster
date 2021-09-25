<?php


namespace PluginMaster\Bootstrap\System;


use PluginMaster\Bootstrap\System\Helpers\App;
use PluginMaster\Foundation\Shortcode\ShortcodeHandler;
use PluginMaster\Contracts\Shortcode\ShortcodeInterface;

class Shortcode implements  ShortcodeInterface
{

    /**
     * @var object
     */
    private static $shortcodeHandler;


    /**
     * @param $name
     * @param $callback
     */
    public static function add( $name, $callback ) {
        static::handler()->add( $name, $callback );
    }

    private static function handler() {
        if ( !static::$shortcodeHandler ) static::$shortcodeHandler = App::get( ShortcodeHandler::class );

        return static::$shortcodeHandler;
    }
}
