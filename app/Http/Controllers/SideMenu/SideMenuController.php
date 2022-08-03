<?php

namespace PluginMaster\App\Http\Controllers\SideMenu;

use PluginMaster\Bootstrap\System\Controller;
use PluginMaster\Bootstrap\System\Helpers\View;

class SideMenuController extends Controller
{

    public function home(): string
    {
        $title = "This is PluginMaster Home Page.";

        return View::render('home', compact('title'));
    }

    public function about(): string
    {
        $title = "This is PluginMaster About Page.";

        return View::render('about', compact('title'));
    }


}
