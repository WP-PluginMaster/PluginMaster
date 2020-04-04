<?php

namespace App\system\core;

class ConfigHandler
{
    private static $instance = null;
    public $config;

    public function __construct()
    {
        $this->config = include plugin_dir_path(__FILE__) . '../../../app/config/config.php';

    }


    /**
     * @return ConfigHandler|null
     */
    public static function init()
    {
        if (self::$instance == null) {
            self::$instance = new ConfigHandler();
        }

        return self::$instance;
    }


    /**
     * @param $key
     * @return mixed
     */
    public function get($key)
    {
        $data = explode('.', $key);
        $finalData = $this->config;
        foreach ($data as $k => $v) {
            $finalData = $finalData[$v];
        }
        return $finalData;
    }

}
