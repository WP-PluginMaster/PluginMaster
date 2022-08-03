<?php


namespace PluginMaster\Bootstrap\System\Providers;

use PluginMaster\Bootstrap\System\Helpers\App;
use PluginMaster\Contracts\Provider\ServiceProviderInterface;
use PluginMaster\Foundation\Api\ApiHandler;

class ApiServiceProvider implements ServiceProviderInterface
{

    protected string $controllerNamespace = 'PluginMaster\\App\\Http\\Controllers\\Api\\';

    public function boot(): void
    {
        $app = App::get();

        add_action('rest_api_init', function () use ($app) {

            /** @var \PluginMaster\Foundation\Api\ApiHandler $apiHandler */
            $apiHandler = $app->get(ApiHandler::class);

            $apiHandler->setAppInstance($app)
                ->setNamespace($app->config('api_namespace'))
                ->setControllerNamespace($this->controllerNamespace)
                ->setMiddleware($app->config('middleware'))
                ->loadRoutes($app->routePath('api.php'));
        });

        add_action('rest_api_init', function () use ($app) {

            /** @var \PluginMaster\Foundation\Api\ApiHandler $apiHandler */
            $apiHandler = $app->get(ApiHandler::class);
            $apiHandler->apiGenerate();

        }, 100);
    }


}
