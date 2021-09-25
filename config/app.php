<?php

use PluginMaster\App\Middleware\TestMiddleware;
use PluginMaster\App\Providers\CacheServiceProvider;
use PluginMaster\Bootstrap\System\Providers\ActionServiceProvider;
use PluginMaster\Bootstrap\System\Providers\ApiServiceProvider;
use PluginMaster\Bootstrap\System\Providers\EnqueueServiceProvider;
use PluginMaster\Bootstrap\System\Providers\InitialDataProvider;
use PluginMaster\Bootstrap\System\Providers\SideMenuServiceProvider;

return [

    /**
     * application/plugin name
     * @type string
     */
    'name'    => "Plugin Master",

    /**
     * application/plugin slug
     * @type string
     */
    'slug'    => "plugin-master",

    /**
     * application/plugin version
     * @type string
     */
    'version' => "1.0.1",

    /**
     * rest api namespace
     * @type string
     */

    'api_namespace'    => "PluginMaster/v1",

    /**
     * side menu config
     */
    'side_menu'        => [
        'cache' => true // file cache
    ],

    /**
     * enqueue config
     */
    'api'              => [
        'cache' => true // file cache
    ],

    /**
     * enqueue config
     */
    'enqueue'          => [
        'cache' => true // file cache
    ],

    /**
     * add your custom Service Providers here
     * service provider path App/Providers
     * @type array
     */
    'providers'        => [
        CacheServiceProvider::class,
    ],

    /**
     * add your rest api middleware here
     * middleware path App/Middleware
     * @type array
     */
    'middleware'       => [
        'test' => TestMiddleware::class
    ],
    /**
     * system service provide
     * do not add your service provider here
     * if you want to disable any system service provider just comment out or remove from here
     * @type array
     */
    'system_providers' => [
        SideMenuServiceProvider::class,
        ApiServiceProvider::class,
        EnqueueServiceProvider::class,
        InitialDataProvider::class,
        ActionServiceProvider::class,
    ],


];
