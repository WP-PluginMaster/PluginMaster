<?php


namespace PluginMaster\Bootstrap\System\Providers;


use PluginMaster\Bootstrap\System\Application;
use PluginMaster\Bootstrap\System\Enqueue;
use PluginMaster\Bootstrap\System\Helpers\App;
use PluginMaster\Contracts\Provider\ServiceProviderInterface;
use PluginMaster\Foundation\Enqueue\EnqueueHandler;

class EnqueueServiceProvider implements ServiceProviderInterface
{

    public function boot(): void
    {
        $app = App::get();

        /** @var \PluginMaster\Foundation\Enqueue\EnqueueHandler $enqueueHandler */
        $enqueueHandler = $app->get(EnqueueHandler::class);

        /** @var  \PluginMaster\Bootstrap\System\Enqueue $enqueue */
        $enqueue = $app->get(Enqueue::class);

        $enqueueHandler->setAppInstance($app)->loadEnqueueFile($app->enqueuePath('enqueue.php'));

        add_action('init', function () use ($enqueueHandler, $enqueue) {
            $enqueueHandler->initEnqueue($enqueue);
        }, 12);
    }


}
