<?php

namespace PluginMaster\Bootstrap;

use PluginMaster\Bootstrap\System\Application;
use PluginMaster\Bootstrap\System\Session;

class Bootstrap
{

    /**
     * boot application
     * @param $path
     */
    public static function boot( $path ): void {

        /**
         * get application instance
         */
        $app = Application::getInstance( $path ) ;


        /**
         * start session for application
         * @need for "PluginMaster\Bootstrap\System\Session" class
         */
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        /**
         * register activation hook
         * run only when plugin activate
         */
        register_activation_hook( $path, [ new Activation(), 'index' ] );

        /**
         * register de-activation hook
         * run only when plugin de-activate
         */
        register_deactivation_hook( $path, [ new DeActivation(), 'index' ] );

        /**
         * Start application with container and boot service providers
         */
        add_action( 'plugins_loaded', function () use ( $app ) {

            $app->boot();

        }, 100 );

        /**
         * destroy onetime flush session
         */
        Session::destroyFlush();
    }

}
