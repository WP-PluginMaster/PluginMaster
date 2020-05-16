<?php

namespace AppSidenav;


use App\system\core\Settings;

class SideMenuRegister
{

    protected $currentMain;
    protected $controller;
    protected $position;
    protected $icon;
    protected $removeSubMenu;

    protected $subMenu;
    protected $subController;
    protected $subTitle;




    public function init()
    {
        global $plugin_path;
        $sidenav = $this;
        require_once Settings::$plugin_path . '/routes/sidenav.php';

    }


    /**
     * @param $nav
     * @param $options
     * @param null $closure
     * @return SideMenu
     */
    public function mainMenu($nav, $options)
    {
        $this->currentMain = $nav;
        $this->controller = $options['as'];
        $this->position = isset($options['position']) ? $options['position'] : 500;
        $this->icon = $options['icon'];
        $this->removeSubMenu = isset($options['removeFirstSubmenu']) ? true : false;
        $this->addMainMenu();

        return $this;
    }


    /**
     * @param $nav
     * @param $options
     */
    public function subMenu($nav, $options)
    {

        $this->subMenu = $nav;
        $this->subController = $options['as'];
        $this->subTitle = isset($options['title']) ? $options['title'] : $nav;

        $this->addSubMenu();

    }

    public function main($nav, $options, $closure = null)
    {
        Settings::$main_menu = $nav;
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



    /**
     * @return mixed
     */
    public function addMainMenu()
    {
        return add_menu_page(
            $this->currentMain,
            $this->currentMain,
            'manage_options',
            $this->currentMain,
            $this->functionArray($this->controller),
            $this->icon,
            $this->position
        );
    }

    public function functionArray($options)
    {
        $exp = explode('@', $options);
        $class = "App" . "\\controller\\" . "sidenav\\" . $exp[0];
        return [new $class(), $exp[1]];
    }

    /**
     * @param $nav
     */
    public function removeFirstSubMenu()
    {
        if ($this->removeSubMenu) {
            remove_submenu_page($this->currentMain, $this->currentMain);
        }
    }

    /**
     * @return mixed
     */
    public function addSubMenu()
    {
        return add_submenu_page(
            $this->currentMain,
            $this->subTitle,
            $this->subTitle,
            'manage_options',
            $this->subMenu,
            $this->functionArray($this->subController)
        );
    }



}
