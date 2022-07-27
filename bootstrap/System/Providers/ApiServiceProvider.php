<?php


namespace PluginMaster\Bootstrap\System\Providers;

use PluginMaster\Bootstrap\System\Helpers\App;
use PluginMaster\Contracts\Provider\ServiceProviderInterface;
use PluginMaster\Foundation\Api\ApiHandler;

class ApiServiceProvider implements ServiceProviderInterface
{

    protected $controllerNamespace = 'PluginMaster\\App\\Http\\Controllers\\Api\\';

    public function boot()
    {
        $app = App::get();

        add_action('rest_api_init', function () use ($app) {
            $app->get(ApiHandler::class)
                ->setAppInstance($app)
                ->setNamespace($app->config('api_namespace'))
                ->setControllerNamespace($this->controllerNamespace)
                ->setMiddleware($app->config('middleware'))
                ->loadRoutes($app->path('routes/api.php'));
        });

        add_action('rest_api_init', function () use ($app) {
            $app->get(ApiHandler::class)
                ->apiGenerate();
        }, 100);
    }


}
