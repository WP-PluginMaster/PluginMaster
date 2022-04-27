<?php

namespace PluginMaster\Bootstrap\System;

use DI\Container;
use DI\DependencyException;
use DI\NotFoundException;
use PluginMaster\Contracts\Foundation\ApplicationInterface;
use PluginMaster\Foundation\Config\ConfigHandler;

class Application implements ApplicationInterface
{

    /**
     * @var null
     */
    protected static $instance = null;
    /**
     * @var Container
     */
    public Container $container;
    /**
     * The base path for the Laravel installation.
     *
     * @var string
     */
    protected string $basePath;
    /**
     * @var boolean
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
     * store accessed config with hashmap
     *
     * @var array
     */
    private array $accessedConfig;


    public function __construct(string $path)
    {
        $this->container = new Container();

        $this->setBasePath($path);
        $this->setAppConfig();
        $this->setVersion($this->config('version'));

    }

    /**
     * @set application base path ( Plugin directory path )
     * @set pluginFile
     * @set pluginBasename
     * @param  string  $path
     * @return mixed
     */
    public function setBasePath($path): void
    {
        $this->pluginFile = $path;
        $this->basePath = untrailingslashit(plugin_dir_path($path));
        $this->pluginBasename = plugin_basename($path);
    }

    /**
     * set ConfigHandler instance inside container
     * and set config path  for ConfigHandler to resolve config data
     * @return mixed
     * @throws DependencyException
     * @throws NotFoundException
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
     * @param $class
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function get($class): object
    {
        return $this->container->get($class);
    }

    /**
     * @param  string  $path
     * @return mixed
     */
    public function configPath(string $path = null): string
    {
        return $this->basePath.DIRECTORY_SEPARATOR.'config'.($path ? DIRECTORY_SEPARATOR.$path : $path);
    }

    /**
     * @param $version
     * @return mixed
     */
    public function setVersion($version): void
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
        if (isset($this->accessedConfig[$key])) {
            return $this->accessedConfig[$key];
        }

        $keys = explode('.', $key);

        $finalData = $this->config;

        foreach ($keys as $key) {
            $finalData = $finalData[$key] ?? '';
        }

        $this->accessedConfig[$key] = $finalData;

        return $finalData;
    }

    /**
     * @param  null  $path
     * @return Application
     */
    public static function getInstance($path = null): Application
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
     * @param  string  $path
     * @return mixed
     */
    public function path($path = null): string
    {
        return $this->basePath.($path ? DIRECTORY_SEPARATOR.$path : $path);
    }

    /**
     * @param  $path
     * @return mixed
     */
    public function asset(string $path): string
    {
        return $this->baseUrl().'assets/'.$path;
    }

    /**
     * @param  null  $path
     * @return mixed
     */
    public function baseUrl($path = null): string
    {
        return trailingslashit(plugins_url('/', $this->pluginFile)).($path ? '/'.$path : $path);
    }

    /**
     * @param  string  $path
     * @return mixed
     */
    public function viewPath(string $path = null): string
    {
        return $this->basePath.DIRECTORY_SEPARATOR.'resources/views'.($path ? DIRECTORY_SEPARATOR.$path : $path);
    }

    /**
     * application cache path
     * @param  string  $path
     * @return mixed
     */
    public function cachePath($path = null): string
    {
        return wp_upload_dir()['basedir'].DIRECTORY_SEPARATOR.$this->config('slug').($path ? DIRECTORY_SEPARATOR.$path : '');
    }

    /**
     * Boot the application's service providers.
     *
     * @return void
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
         * run application service providers for modules / functionalities
         */
        foreach ($this->config('providers') as $serviceProvider) {
            if (method_exists($serviceProvider, 'boot')) {
                $this->call([$serviceProvider, 'boot']);
            }
        }
    }

    /**
     * @param $callable
     * @param  array  $parameters
     * @return mixed
     */
    public function call($callable, array $parameters = [])
    {
        return $this->container->call($callable, $parameters);
    }

}
