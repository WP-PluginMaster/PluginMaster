<?php


namespace PluginMaster\Bootstrap\System\Providers;


use PluginMaster\Bootstrap\System\Helpers\App;
use PluginMaster\Contracts\Provider\ServiceProviderInterface;
use PluginMaster\Foundation\Shortcode\ShortcodeHandler;

class ShortcodeServiceProvider implements ServiceProviderInterface
{

    protected string $controllerNamespace = 'PluginMaster\\App\\Http\\Controllers\\Shortcodes\\';

    public function boot(): void
    {
        $app = App::get();

        /** @var ShortcodeHandler $shortcodeHandler */
        $shortcodeHandler = $app->get(ShortcodeHandler::class);

        $shortcodeHandler->setAppInstance($app)
            ->setControllerNamespace($this->controllerNamespace)
            ->loadFile($app->hooksPath('shortcode.php'));
    }


}
