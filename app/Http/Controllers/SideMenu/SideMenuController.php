<?php

namespace PluginMaster\App\Http\Controllers\SideMenu;

use PluginMaster\Bootstrap\System\Controller;
use PluginMaster\Bootstrap\System\Helpers\View;

class SideMenuController extends Controller
{

    public function home(): string
    {
        $title = "This is PluginMaster Home Page.";

        return View::render('index', compact('title'));
    }

    public function react(): string
    {
        return View::render('react-app');
    }

    public function vue(): string
    {
        return View::render('vue-app');
    }


}
