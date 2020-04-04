<?php

namespace App\system\sidenav;


use App\system\core\base\Sidenav;

class sideNavRoute implements Sidenav
{

    public $currentMain = '';

    public function routes()
    {
        sidenav_file($this);
    }


    public function main($nav, $options, $closure = null)
    {
        global $mainMenu;
        $mainMenu =  $nav  ;
        $icon = $options['icon'];
        $position = isset($options['position']) ? $options['position'] : 500;

        $function = $this->generateFunction($options['as']);

        add_menu_page(
            $nav,
            $nav,
            'manage_options',
            $nav,
            $function,
            $icon,
            $position
        );


        $this->currentMain = $nav;

        if ($closure instanceof \Closure) {
            call_user_func($closure, $this);
        }

        if (isset($options['removeFirstSubmenu']) && $options['removeFirstSubmenu']) {
            remove_submenu_page($nav, $nav);
        }

    }


    public function generateFunction($options)
    {
        $exp = explode('@', $options);
        $class = "App" . "\\controller\\" . "sidenav\\" . $exp[0];
        return [new $class(), $exp[1]];
    }

    public function sub($nav, $options)
    {

        $function = $this->generateFunction($options['as']);
        $title = isset($options['title']) ? $options['title'] : $nav;

        add_submenu_page(
            $this->currentMain,
            $title,
            $title,
            'manage_options',
            $nav,
            $function
        );

    }


}
