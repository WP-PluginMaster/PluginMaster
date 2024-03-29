<?php

namespace PluginMaster\Bootstrap\System;

use PluginMaster\Contracts\Foundation\ApplicationInterface;
use PluginMaster\Foundation\Config\ConfigHandler;
use PluginMaster\Foundation\DIC\DependencyInjectionContainer;

class Application extends DependencyInjectionContainer implements ApplicationInterface
{
    /**
     * @var Application|null
     */
    protected static ?self $instance = null;

    /**
     * The base path for the Laravel installation.
     *
     * @var string
     */
    protected string $basePath;

    /**
     * @var bool
     */
    protected bool $booted = false;

    /**
     * @var string
     */
    protected string $pluginFile;

    /**
     * @var string
     */
    protected string $pluginBasename;


    /**
     * @var array
     */
    protected array $config = [];

    /**
     * The PluginMaster version.
     *
     * @var string
     */
    private string $version;

    /**
     * @throws \ReflectionException
     */
    public function __construct(string $path)
    {
        $this->setBasePath($path);
        $this->setAppConfig();
        $this->setVersion($this->config('version'));
    }

    /**
     * @set application base path ( Plugin directory path )
     * @set pluginFile
     * @set pluginBasename
     * @param string $path
     * @return mixed
     */
    public function setBasePath(string $path): void
    {
        $this->pluginFile = $path;
        $this->basePath = untrailingslashit(plugin_dir_path($path));
        $this->pluginBasename = plugin_basename($path);
    }

    /**
     * set ConfigHandler instance inside container
     * and set config path  for ConfigHandler to resolve config data
     * @return mixed
     * @throws \ReflectionException
     */
    private function setAppConfig(): void
    {
        // create instance
        $configHandler = $this->get(ConfigHandler::class);
        $configHandler->setPath($this->configPath());

        // set app config data from config/app.php
        $this->config = $configHandler->resolveData('app');
    }

    /**
     * @param string|null $path
     * @return mixed
     */
    public function configPath(string $path = null): string
    {
        return $this->basePath . DIRECTORY_SEPARATOR . 'config' . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }

    /**
     * @param string $version
     * @return mixed
     */
    public function setVersion(string $version): void
    {
        $this->version = $version;
    }

    /**
     * get app config data
     * just pass config/app.php 's array key to access (Like config('provider') - do not need to pass 'app.providers') )
     * @param $key
     * @return mixed
     */
    public function config($key)
    {
        $keys = explode('.', $key);

        $finalData = $this->config;

        foreach ($keys as $key) {
            $finalData = $finalData[$key] ?? '';
        }

        return $finalData;
    }

    /**
     * @param null $path
     * @return Application
     * @throws \ReflectionException
     */
    public static function getInstance($path = null): ?Application
    {
        if (null === self::$instance) {
            self::$instance = new self($path);
        }

        return self::$instance;
    }

    /**
     * Get the version number of the application.
     *
     * @return string
     */
    public function version(): string
    {
        return $this->version;
    }

    /**
     * Get the plugin base name.
     *
     * @return string
     */
    public function baseName(): string
    {
        return $this->pluginBasename;
    }

    /**
     * @param string|null $path
     * @return mixed
     */
    public function basePath(string $path = null): string
    {
        return $this->basePath . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }

    /**
     * @param string $path
     * @return mixed
     */
    public function asset(string $path): string
    {
        return $this->baseUrl() . 'assets/' . $path;
    }

    /**
     * @param null $path
     * @return mixed
     */
    public function baseUrl($path = null): string
    {
        return trailingslashit(plugins_url('/', $this->pluginFile)) . ($path ? '/' . $path : $path);
    }

    /**
     * @param string|null $path
     * @return mixed
     */
    public function bootstrapPath(string $path = null): string
    {
        return $this->basePath . DIRECTORY_SEPARATOR . 'bootstrap' . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }

    /**
     * @param string|null $path
     * @return mixed
     */
    public function appPath(string $path = null): string
    {
        return $this->basePath . DIRECTORY_SEPARATOR . 'app' . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }

    /**
     * @param string $path
     * @return mixed
     */
    public function databasePath(string $path = ''): string
    {
        return $this->basePath . DIRECTORY_SEPARATOR . 'database' . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }

    /**
     * @param string|null $path
     * @return mixed
     */
    public function viewPath(string $path = null): string
    {
        return $this->basePath . DIRECTORY_SEPARATOR . 'resources/views' . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }

    /**
     * @param string|null $path
     * @return mixed
     */
    public function assetPath(string $path = null): string
    {
        return $this->basePath . DIRECTORY_SEPARATOR . 'assets' . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }

    /**
     * @param string|null $path
     * @return mixed
     */
    public function enqueuePath(string $path = null): string
    {
        return $this->basePath . DIRECTORY_SEPARATOR . 'enqueues' . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }

    /**
     * @param string|null $path
     * @return mixed
     */
    public function hookPath(string $path = null): string
    {
        return $this->basePath . DIRECTORY_SEPARATOR . 'hooks' . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }

    /**
     * @param string|null $path
     * @return mixed
     */
    public function routePath(string $path = null): string
    {
        return $this->basePath . DIRECTORY_SEPARATOR . 'routes' . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }

    /**
     * @param string|null $path
     * @return mixed
     */
    public function hooksPath(string $path = null): string
    {
        return $this->basePath . DIRECTORY_SEPARATOR . 'hooks' . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }

    public function cachePath($path = null): string
    {
        return wp_upload_dir()['basedir'] . DIRECTORY_SEPARATOR . $this->config(
                'slug'
            ) . ($path ? DIRECTORY_SEPARATOR . $path : '');
    }

    /**
     * Boot the application's service providers.
     *
     * @return void
     * @throws \ReflectionException
     */
    public function boot(): void
    {
        if ($this->isBooted()) {
            return;
        }

        $this->bootProvider();
        $this->booted = true;
    }

    /**
     * Determine if the application has booted.
     *
     * @return bool
     */
    public function isBooted(): bool
    {
        return $this->booted;
    }

    /**
     * boot service providers
     * @return void
     * @throws \ReflectionException
     */
    protected function bootProvider(): void
    {
        /**
         * run system service providers
         */
        foreach ($this->config('system_providers') as $serviceProvider) {
            if (method_exists($serviceProvider, 'boot')) {
                $this->call([$serviceProvider, 'boot']);
            }
        }

        /**
         * run your service providers for your modules / functionalities
         */
        foreach ($this->config('providers') as $serviceProvider) {
            if (method_exists($serviceProvider, 'boot')) {
                $this->call([$serviceProvider, 'boot']);
            }
        }
    }

}
