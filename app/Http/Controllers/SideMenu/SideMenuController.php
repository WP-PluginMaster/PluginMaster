<?php

namespace PluginMaster\App\Http\Controllers\SideMenu;

use PluginMaster\Bootstrap\System\Controller;
use PluginMaster\Bootstrap\System\Helpers\App;

class SideMenuController extends Controller
{

    public function index() {

        $title = "This is PluginMaster for creating plugin in better way.";

        return App::view( 'index', compact( 'title' ) );
    }


}
