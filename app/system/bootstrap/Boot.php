<?php


namespace App\system\bootstrap;
require_once plugin_dir_path(__FILE__) . '../global.php';

use App\system\enqueue\EnqueueRegister;
use App\system\router\RestRouteRegister;
use App\system\sidenav\SideMenuRegister;
use App\system\sidenav\sideNavRoute;

class Boot
{

    public static function init()
    {
        global $plugin_base;
        $active = new Activator();
        $deActive = new  DeActivator();

        register_activation_hook($plugin_base, [$active, 'activate']);
        register_deactivation_hook($plugin_base, [$deActive, 'deactivate']);

        add_action('rest_api_init', [new RestRouteRegister(), 'init']); // active api route
        add_action('admin_menu', array(new SideMenuRegister(), 'init')); // active sidenav
         (new EnqueueRegister())->initAsset();
    }

}
