<?php

namespace App\system\sidenav;


use PluginMaster\SideMenu\SideMenu;

class SideMenuRegister extends SideMenu
{

    public function init()
    {
        $sidenav = $this;
        require_once plugin_dir_path(__FILE__) . '../../../routes/sidenav.php';

    }

    public function main($nav, $options, $closure = null)
    {
        global $mainMenu;
        $mainMenu = $nav;
        $this->mainMenu($nav, $options);

        if ($closure instanceof \Closure) {
            call_user_func($closure, $this);
        }

        $this->removeFirstSubMenu();
    }

    public function sub($nav, $options)
    {
        $this->subMenu($nav, $options);

    }


}
