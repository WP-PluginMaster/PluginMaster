<?php


namespace PluginMaster\Bootstrap\System\Providers;


use PluginMaster\Bootstrap\System\Helpers\App;
use PluginMaster\Bootstrap\System\SideMenu;
use PluginMaster\Contracts\Provider\ServiceProviderInterface;
use PluginMaster\Foundation\SideMenu\SideMenuHandler;

class SideMenuServiceProvider implements ServiceProviderInterface
{
    protected string $controllerNamespace = 'PluginMaster\\App\\Http\\Controllers\\SideMenu\\';

    public function boot(): void
    {
        $app = App::get();

        /** @var SideMenu $SideMenu */
        $SideMenu = $app->get(SideMenu::class);

        add_action('admin_menu', function () use ($app, $SideMenu) {

            /** @var SideMenuHandler $sideMenuHandler */
            $sideMenuHandler = $app->get(SideMenuHandler::class);

            $sideMenuHandler->setAppInstance($app)
                ->setNamespace($this->controllerNamespace)
                ->loadMenuFile($app->routePath('sidemenu.php'))
                ->setSideMenu($SideMenu);

        });

        add_action('admin_menu', function () use ($app) {
            $app->get(SideMenuHandler::class)->removeFirstSubMenu();
        }, 12);
    }


}
