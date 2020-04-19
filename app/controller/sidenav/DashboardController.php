<?php


namespace App\controller\sidenav;

use App\system\controller\Controller;


class DashboardController extends Controller
{

    public function documentation()
    {
         $pageTitle = " PluginMaster (an Application Development Framework for Wordpress)";
         return view('documentation', compact('pageTitle'));
    }

}
