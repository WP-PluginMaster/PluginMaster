<?php


namespace PluginMaster\Bootstrap\System\Providers;

use PluginMaster\Bootstrap\System\Enqueue;
use PluginMaster\Bootstrap\System\Helpers\App;
use PluginMaster\Contracts\Provider\ServiceProviderInterface;

class InitialDataProvider implements ServiceProviderInterface
{

    /**
     * execute  service provider code
     * @for setting up initial localize script data
     */
    public function boot(): void
    {
        /**
         * Application instance
         */
        $app = App::get();

        /**
         *  application slug ( in config/app.php as 'slug')
         */
        $slug = $app->config('slug');

        /**
         *  basic data need for ajax request
         *  you can add your custom data here
         */
        $data = [
            "name"          => $app->config('name'),
            "slug"          => $slug,
            "version"       => $app->version(),
            "api_namespace" => $app->config('api_namespace'),
            'api_endpoint' => home_url().'?rest_route=/'.$app->config('api_namespace'),
            "ajax_url"      => admin_url('admin-ajax.php'),
            "nonce"         => wp_create_nonce("wp_rest")
        ];

        /**
         * generate object name from application slug ( in config/app.php as 'slug')
         */
        $objectName = str_replace("-", "_", $slug);

        /**
         * add localize script data
         * @for admin area
         */
        Enqueue::admin()->localizeScript('jquery-core', $objectName, $data);

        /**
         * add localize script data
         * @for front-end area
         */
        Enqueue::front()->localizeScript('jquery-core', $objectName, $data);

    }


}
