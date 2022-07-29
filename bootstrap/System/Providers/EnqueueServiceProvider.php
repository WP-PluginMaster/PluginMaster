<?php


namespace PluginMaster\Bootstrap\System\Providers;


use PluginMaster\Bootstrap\System\Application;
use PluginMaster\Bootstrap\System\Helpers\App;
use PluginMaster\Contracts\Provider\ServiceProviderInterface;
use PluginMaster\Foundation\Enqueue\EnqueueHandler;

class EnqueueServiceProvider implements ServiceProviderInterface
{

    public function boot(): void
    {
        /** @var Application $app */
        $app = App::get();

        /** @var EnqueueHandler $enqueueHandler */
        $enqueueHandler = $app->get(EnqueueHandler::class);

        $enqueueHandler->setAppInstance($app)->loadEnqueueFile($app->enqueuePath('enqueue.php'));

        add_action('admin_enqueue_scripts', function () use ($enqueueHandler) {
            $enqueueHandler->initEnqueue();
        });

        add_action('wp_enqueue_scripts', function () use ($enqueueHandler) {
            $enqueueHandler->initEnqueue();
        }, 100);
    }


}
