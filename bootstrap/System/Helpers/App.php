<?php


namespace PluginMaster\Bootstrap\System\Helpers;

use PluginMaster\Bootstrap\System\Application;
use PluginMaster\Foundation\View\ViewHandler;


class App
{

    /**
     * @var ViewHandler
     */
    protected static $viewHandler;

    /**
     * @return mixed|string
     */
    public static function basePath()
    {
        return static::get()->basePath();
    }

    /**
     * @param  null  $class
     * @return Application|null
     */
    public static function get($class = null)
    {
        if (is_null($class)) {
            return Application::getInstance();
        }

        return Application::getInstance()->get($class);
    }

    /**
     * access only config/app.php 's config data
     * no need to pass app just like: config('slug') for app slug name
     * @param $key
     * @return Application|null
     */
    public static function config($key)
    {
        return static::get()->config($key);
    }

    /**
     * @return mixed|string
     */
    public static function baseUrl()
    {
        return static::get()->baseUrl();
    }

    /**
     * @return mixed|string
     */
    public static function textDomain()
    {
        return static::get()->config('slug');
    }

}
