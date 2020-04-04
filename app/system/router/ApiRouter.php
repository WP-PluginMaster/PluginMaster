<?php

namespace App\system\router;


use App\system\core\base\Router;

class ApiRouter extends Router
{


    public function routes()
    {
        route_file($this);
    }

    /**
     * @param $route
     * @param $callback
     * @param bool $secure
     */
    public function get($route, $callback, $secure = false)
    {

        $formattedRoute = $this->formatRoute($route);
        $options = $this->generateRouteOptions($callback, 'GET');

        register_rest_route(
            config('api_version'),
            '/' . $formattedRoute,
            $options
        );
    }


    /**
     * @param $route
     * @param $callback
     * @param bool $secure
     */
    public function post($route, $callback, $secure = false)
    {
        $formattedRoute = $this->formatRoute($route);
        $options = $this->generateRouteOptions($callback, 'POST');

        if ($secure) {
            $options['permission_callback'] = array($this, 'check_permission');
        }
        register_rest_route(
            config('api_version'),
            '/' . $formattedRoute,
            $options
        );
    }


}
