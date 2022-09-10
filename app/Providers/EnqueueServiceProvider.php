<?php


namespace PluginMaster\App\Providers;


use PluginMaster\Contracts\Provider\ServiceProviderInterface;

class EnqueueServiceProvider implements ServiceProviderInterface
{

    public function boot(): void
    {
        add_action( 'wp_enqueue_scripts', [$this, 'addFrontendEnqueue'] );
        add_action( 'admin_enqueue_scripts', [$this, 'addAdminEnqueue'] );
    }

    public function addFrontendEnqueue()
    {
    }

    public function addAdminEnqueue()
    {
        wp_enqueue_style( 'plugin-master-css', plugin_master_app()->baseUrl('assets/css/app.css'), [], plugin_master_config('app.version') );
        wp_enqueue_script( 'plugin-master-react', plugin_master_app()->baseUrl('assets/js/react/app.js'), ['jquery'], plugin_master_config('app.version'), true );
        wp_enqueue_script( 'plugin-master-vue', plugin_master_app()->baseUrl('assets/js/vue/app.js'), ['jquery'], plugin_master_config('app.version'), true );
    }

}
