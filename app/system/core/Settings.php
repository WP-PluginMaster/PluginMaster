<?php


namespace App\system\core;


class Settings
{

    public static $plugin_root;
    public static $plugin_path;
    public static $main_menu;
    public static $plugin_dir;

    public static function init($path)
    {
        self::$plugin_root = plugin_basename($path);
        self::$plugin_dir = plugin_dir_path(Settings::$plugin_root);
        self::$plugin_path = plugin_dir_path($path);
    }

}
