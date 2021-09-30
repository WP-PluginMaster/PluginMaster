<?php

namespace PluginMaster\App\Http\Controllers\SideMenu;

use PluginMaster\Bootstrap\System\Controller;
use PluginMaster\Bootstrap\System\Helpers\App;
use PluginMaster\Bootstrap\System\Helpers\View;

class SideMenuController extends Controller
{

    public function index() {

        $title = "This is PluginMaster for creating plugin in better way.";

        return View::render( 'index', compact( 'title' )  );
    }


}
