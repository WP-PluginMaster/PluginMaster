<?php

namespace App\system\router;

use App\system\core\Settings;
use PluginMaster\Routing\Router;

class RestRouteRegister extends Router
{

    private $namespace;

    public function __construct()
    {
        $this->namespace = config('api_namespace');
    }

    public function init()
    {
        $route = $this;
        require_once Settings::$plugin_path. '/routes/route.php';
    }

    /**
     * @param $route
     * @param $callback
     * @param bool $secure
     */
    public function get($route, $callback, $secure = false)
    {
        $this->getRoute($route, $callback, $this->namespace, $secure = false);
    }


    /**
     * @param $route
     * @param $callback
     * @param bool $secure
     */
    public function post($route, $options, $secure = false)
    {
        $this->postRoute($route, $options, $this->namespace, $secure = false);

    }


}
