<?php


namespace PluginMaster\Bootstrap\System;


use PluginMaster\Bootstrap\System\Helpers\App;
use PluginMaster\Contracts\SideMenu\SideMenuInterface;
use PluginMaster\Foundation\SideMenu\SideMenuHandler;

class SideMenu implements SideMenuInterface
{

    /**
     * @var null
     */
    protected static $parentSlug = null;


    /**
     * $option['as'] required
     * $option['title'] for both- page & menu
     *
     * @param $slug
     * @param $options
     * @param  null  $callback
     */
    public static function parent($slug, $options, $callback = null)
    {

        static::$parentSlug = $slug;

        static::registerMenu($slug, $options, true);

        if (gettype($callback) == 'object') {

            call_user_func($callback);

            // reset slug
            static::$parentSlug = null;
        }
    }


    /**
     * @param $slug
     * @param $options
     * @param  bool  $parent
     */
    private static function registerMenu($slug, $options, $parent = false)
    {
        $instance = App::get(SideMenuHandler::class);
        $instance->validateOptions($options, $parent);

        if ($parent) {
            $instance->addMenuPage($slug, $options);
        } else {
            $instance->addSubMenuPage($slug, $options, static::$parentSlug);
        }
    }

    /**
     * $option['as'] required
     * @param $slug
     * @param $options
     */
    public static function child($slug, $options)
    {

        static::registerMenu($slug, $options, false);
    }

}
