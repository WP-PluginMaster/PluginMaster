<?php

use PluginMaster\App\Http\Middleware\TestMiddleware;
use PluginMaster\App\Providers\TestServiceProvider;
use PluginMaster\Bootstrap\System\Providers\ActionServiceProvider as SystemActionServiceProvider;
use PluginMaster\Bootstrap\System\Providers\ApiServiceProvider as SystemApiServiceProvider;
use PluginMaster\Bootstrap\System\Providers\EnqueueServiceProvider as SystemEnqueueServiceProvider ;
use PluginMaster\Bootstrap\System\Providers\InitialDataProvider;
use PluginMaster\Bootstrap\System\Providers\ShortcodeServiceProvider as SystemShortcodeServiceProvider;
use PluginMaster\Bootstrap\System\Providers\SideMenuServiceProvider as SystemSideMenuServiceProvider;

return [

    /**
     * application/plugin name
     * @type string
     */
    'name' => "Plugin Master",

    /**
     * application/plugin slug/text domain
     * @type string
     */
    'slug' => "plugin-master",

    /**
     * application/plugin version
     * @type string
     */
    'version' => "1.0.1",

    /**
     * rest api namespace
     * @type string
     */

    'api_namespace' => "PluginMaster/v1",

    /**
     * add your custom Service Providers here
     * service provider path App/Providers
     * @type array
     */
    'providers' => [
        TestServiceProvider::class,
    ],

    /**
     * add your rest api middleware here
     * middleware path App/Middleware
     * @type array
     */
    'middleware' => [
        'test' => TestMiddleware::class
    ],

    /**
     * system service provide
     * do not add your service provider here
     * if you want to disable any system service provider just comment out or remove from here
     * @type array
     */
    'system_providers' => [
        SystemSideMenuServiceProvider::class,
        SystemApiServiceProvider::class,
        SystemActionServiceProvider::class,
        SystemShortcodeServiceProvider::class,
        SystemEnqueueServiceProvider::class,
        InitialDataProvider::class,
    ],
];
