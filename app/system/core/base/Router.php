<?php


namespace App\system\core\base;


abstract class Router
{
    protected $args = [];

    abstract function get($route, $callback, $secure = false);

    abstract function post($route, $callback, $secure = false);


    /**
     * @param $route
     * @return string|string[]
     */
    protected function formatRoute($route)
    {
        if (strpos($route, '?}') !== false) {
            $route = $this->optionalParam($route);
        } else {
            $route = $this->requiredParam($route);
        }
        return $route;
    }

    /**
     * @param $route
     * @return string|string[]
     */
    protected function optionalParam($route)
    {
        preg_match_all('#\{(.*?)\}#', $route, $match);
        foreach ($match[0] as $k => $v) {
            $route = str_replace('/' . $v, '(?:/(?P<' . str_replace('?', '', $match[1][$k]) . '>\d+))?', $route);
            array_push($this->args, $match[1][$k]);
        }
        return $route;
    }

    /**
     * @param $route
     * @return string|string[]
     */
    protected function requiredParam($route)
    {
        preg_match_all('#\{(.*?)\}#', $route, $match);
        foreach ($match[0] as $k => $v) {
            $route = str_replace($v, '(?P<' . $match[1][$k] . '>\d+)', $route);
            array_push($this->args, $match[1][$k]);
        }
        return $route;
    }

    /**
     * @param $callback
     * @param $method
     * @return array
     */
    protected function generateRouteOptions($callback, $method)
    {
        $controllerMethodExtract = explode('@', $callback);

        $class = "App" . "\\controller\\" . "api\\" . $controllerMethodExtract[0];
        $methodKey = $method === 'GET' ? 'method' : 'methods';
        return [
            $methodKey => $method,
            'callback' => [new $class(), $controllerMethodExtract[1]],
            'args' => $this->args
        ];


    }


    /**
     * @return bool
     */
    protected function check_permission()
    {
        return current_user_can('manage_options');
    }


}
