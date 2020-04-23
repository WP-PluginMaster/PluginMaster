<?php


namespace App\system\bootstrap;

session_start();

use App\system\core\Settings;
use App\system\session\Session;
require_once Settings::$plugin_path . 'app/system/global.php';



use App\system\enqueue\EnqueueRegister;
use App\system\router\RestRouteRegister;
use App\system\sidenav\SideMenuRegister;

class Boot
{

    public static function init()
    {
        $active = new Activator();
        $deActive = new  DeActivator();

        register_activation_hook(Settings::$plugin_path, [$active, 'activate']);
        register_deactivation_hook(Settings::$plugin_path, [$deActive, 'deactivate']);

        add_action('rest_api_init', [new RestRouteRegister(), 'init']); // active api route
        add_action('admin_menu', array(new SideMenuRegister(), 'init')); // active sidenav
         (new EnqueueRegister())->initAsset();
         Session::unsetFlashSession();
    }

}
