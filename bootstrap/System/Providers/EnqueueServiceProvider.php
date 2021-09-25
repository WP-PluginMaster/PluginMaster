<?php


namespace PluginMaster\Bootstrap\System\Providers;


use PluginMaster\Bootstrap\System\Helpers\App;
use PluginMaster\Contracts\Provider\ServiceProviderInterface;
use PluginMaster\Foundation\Enqueue\EnqueueHandler;

class EnqueueServiceProvider  implements ServiceProviderInterface
{

    public function boot() {

        $app = App::get();

        $app->get( EnqueueHandler::class )->setAppInstance( $app )->loadEnqueueFile( $app->enqueuePath( 'enqueue.php' ) );

        add_action( 'admin_enqueue_scripts', function () use ( $app ) {
            $app->get( EnqueueHandler::class )->initEnqueue(true) ;
        } );

        add_action( 'wp_enqueue_scripts', function () use ( $app ) {
            $app->get( EnqueueHandler::class )->initEnqueue() ;
        } , 100);


    }


}
