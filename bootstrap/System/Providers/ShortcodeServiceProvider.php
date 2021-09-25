<?php


namespace PluginMaster\Bootstrap\System\Providers;


use PluginMaster\Bootstrap\System\Helpers\App;
use PluginMaster\Contracts\Provider\ServiceProviderInterface;
use PluginMaster\Foundation\Shortcode\ShortcodeHandler;

class ShortcodeServiceProvider implements ServiceProviderInterface
{

    protected $controllerNamespace = 'PluginMaster\\App\\Controllers\\Shortcodes\\';

    public function boot() {
        $app = App::get();
        $app->get( ShortcodeHandler::class )
            ->setAppInstance( $app )
            ->setControllerNamespace( $this->controllerNamespace )
            ->loadFile( $app->hooksPath( 'shortcode.php' ) );
    }


}
