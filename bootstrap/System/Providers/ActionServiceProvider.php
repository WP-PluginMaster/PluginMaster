<?php


namespace PluginMaster\Bootstrap\System\Providers;


use PluginMaster\Bootstrap\System\Helpers\App;
use PluginMaster\Contracts\Provider\ServiceProviderInterface;
use PluginMaster\Foundation\Action\ActionHandler;

class ActionServiceProvider implements ServiceProviderInterface
{

    protected $controllerNamespace = 'PluginMaster\\App\\Http\\Controllers\\Actions\\';

    public function boot(): void
    {
        $app = App::get();
        $app->get(ActionHandler::class)
            ->setAppInstance($app)
            ->setControllerNamespace($this->controllerNamespace)
            ->loadFile($app->path('hooks/action.php'));
    }


}
