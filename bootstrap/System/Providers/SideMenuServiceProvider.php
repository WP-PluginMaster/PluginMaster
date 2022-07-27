<?php


namespace PluginMaster\Bootstrap\System\Providers;


use PluginMaster\Bootstrap\System\Helpers\App;
use PluginMaster\Contracts\Provider\ServiceProviderInterface;
use PluginMaster\Foundation\SideMenu\SideMenuHandler;

class SideMenuServiceProvider implements ServiceProviderInterface
{

    protected $controllerNamespace = 'PluginMaster\\App\\Http\\Controllers\\SideMenu\\';

    public function boot()
    {
        $app = App::get();

        add_action('admin_menu', function () use ($app) {
            $app->get(SideMenuHandler::class)->setAppInstance($app)->setNamespace($this->controllerNamespace)
                ->loadMenuFile($app->path('sidemenu.php'));
        });

        add_action('admin_menu', function () use ($app) {
            $app->get(SideMenuHandler::class)->removeFirstSubMenu();
        }, 12);
    }


}
