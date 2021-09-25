<?php

namespace PluginMaster\App\Controllers\SideMenu;

use PluginMaster\Bootstrap\System\Controller;
use PluginMaster\Bootstrap\System\Session;
use PluginMaster\Bootstrap\System\View;

class SideMenuController extends Controller
{

    public function index() {
        Session::forget("title" );
        $title = "Hello EMRAN" ;

        return View::add( 'index',compact('title') );
    }


}
