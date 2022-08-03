<?php


namespace PluginMaster\Bootstrap\System\Providers;


use PluginMaster\Bootstrap\System\Helpers\App;
use PluginMaster\Contracts\Provider\ServiceProviderInterface;
use PluginMaster\Foundation\Action\ActionHandler;

class ActionServiceProvider implements ServiceProviderInterface
{

    protected string $controllerNamespace = 'PluginMaster\\App\\Http\\Controllers\\Actions\\';

    public function boot(): void
    {
        $app = App::get();

        /** @var \PluginMaster\Foundation\Action\ActionHandler $actionHandler */
        $actionHandler = $app->get(ActionHandler::class);

        $actionHandler->setAppInstance($app)
            ->setControllerNamespace($this->controllerNamespace)
            ->loadFile($app->hooksPath('action.php'));
    }


}
