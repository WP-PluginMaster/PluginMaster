<?php


namespace App\system\bootstrap;

session_start();

use App\system\core\Settings;
use App\system\enqueue\EnqueueRegister;
use App\system\router\RestRouteRegister;
use App\system\session\Session;
use App\system\shortcode\ShortCodeRegister;
use AppSidenav\SideMenuRegister;

require_once Settings::$plugin_path . 'app/system/global.php';


class Boot
{

    public static function init()
    {
        $active = new Activator();
        $deActive = new  DeActivator();
        register_activation_hook(Settings::$plugin_root, [$active, 'activate']);
        register_deactivation_hook(Settings::$plugin_root, [$deActive, 'deactivate']);
        add_action('rest_api_init', [new RestRouteRegister(), 'init']); // active api route
        add_action('admin_menu', array(new SideMenuRegister(), 'init')); // active sidenav
        (new EnqueueRegister())->initAsset();
        (new ShortCodeRegister())->init();
        Session::unsetFlashSession();
    }

}
