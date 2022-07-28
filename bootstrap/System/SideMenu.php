<?php


namespace PluginMaster\Bootstrap\System;


use PluginMaster\Bootstrap\System\Helpers\App;
use PluginMaster\Contracts\SideMenu\SideMenuInterface;
use PluginMaster\Foundation\SideMenu\SideMenuHandler;

class SideMenu implements SideMenuInterface
{

    /**
     * @var string|null
     */
    protected static ?string $parentSlug = null;


    /**
     * $option['as'] required
     * $option['title'] for both- page & menu
     *
     * @param string $slug
     * @param array $options
     * @param callable|null $callback
     */
    public static function parent(string $slug, array $options, callable $callback = null): void
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
     * @param bool $parent
     */
    private static function registerMenu($slug, $options, $parent = false)
    {
        /** @var SideMenuHandler $instance */
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
     * @param string $slug
     * @param array $options
     */
    public static function child(string $slug, array $options): void
    {
        static::registerMenu($slug, $options, false);
    }

}
