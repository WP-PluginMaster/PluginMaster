<?php


namespace PluginMaster\Bootstrap\System\Providers;


use PluginMaster\Bootstrap\System\Helpers\App;
use PluginMaster\Contracts\Provider\ServiceProviderInterface;
use PluginMaster\Foundation\Enqueue\EnqueueHandler;

class EnqueueServiceProvider implements ServiceProviderInterface
{

    public function boot()
    {

        $app = App::get();

        $app->get(EnqueueHandler::class)->setAppInstance($app)->loadEnqueueFile($app->path('enqueues/enqueue.php'));

        if (is_admin()) {

            add_action('admin_init', function () use ($app) {
                $app->get(EnqueueHandler::class)->initEnqueue();
            });

        } else {

            add_action('wp_head', function () use ($app) {
                $app->get(EnqueueHandler::class)->initEnqueue();
            });

        }

    }

}
