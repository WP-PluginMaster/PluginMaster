<?php

namespace App\system\shortcode;


use App\system\core\Settings;

class ShortCodeRegister
{


    /**
     * @param $hook
     */
    public function init()
    {
        $shortCode = $this;
        require_once Settings::$plugin_path . '/shortcode/shortcode.php';

    }

    /**
     * @param $name
     * @param $namespace
     */
    private function add($name, $namespace)
    {
        add_shortcode($name, $this->generateController($namespace));

    }


    protected function generateController($callback)
    {
        $controllerMethodExtract = explode('@', $callback);

        $class = "App" . "\\controller\\" . "shortcode\\" . $controllerMethodExtract[0];

        return [new $class(), $controllerMethodExtract[1]];
    }


}
