<?php

namespace PluginMaster\Bootstrap\System;


use PluginMaster\Bootstrap\System\Helpers\App;
use PluginMaster\Contracts\Enqueue\EnqueueInterface;
use PluginMaster\Foundation\Enqueue\EnqueueHandler;

class Enqueue implements EnqueueInterface
{

    /**
     * @var string
     */
    protected static string $hook;

    /**
     * @var Enqueue|null
     */
    private static ?self $instance = null;


    /**
     * @var EnqueueHandler|null
     */
    private static ?EnqueueHandler $enqueueManager = null;

    /**
     * @return Enqueue
     */
    public static function front(): self
    {
        static::$hook = 'admin_enqueue_scripts';
        return self::getInstance();
    }

    /**
     * @return Enqueue|null
     */
    private static function getInstance(): self
    {
        if (null === self::$instance) {
            self::$instance = new self();
            self::$enqueueManager = App::get(EnqueueHandler::class);
        }

        return self::$instance;
    }

    /**
     * @return Enqueue
     */
    public static function admin(): self
    {
        static::$hook = 'wp_enqueue_scripts';
        return static::getInstance();
    }

    public static function on($hook): self
    {
        static::$hook = $hook;
        return static::getInstance();
    }

    /**
     * @param string $path
     * @param array $options
     */
    public function headerScript(string $path, array $options = []): void
    {
        self::$enqueueManager->register([$path, $options, true, false, false], static::$hook);
    }

    /**
     * @param string $path
     * @param array $options
     */
    public function headerScriptCdn(string $path, array $options = []): void
    {
        self::$enqueueManager->register([$path, $options, true, false, true], static::$hook);
    }

    /**
     * @param string $path
     * @param array $options
     */
    public function footerScript(string $path, array $options = []): void
    {
        self::$enqueueManager->register([$path, $options, true, true, false], static::$hook);
    }

    /**
     * @param string $path
     * @param array $options
     */
    public function footerScriptCdn(string $path, array $options = []): void
    {
        self::$enqueueManager->register([$path, $options, true, true, true], static::$hook);
    }

    /**
     * @param string $path
     * @param array $options
     */
    public function style(string $path, array $options = []): void
    {
        self::$enqueueManager->register([$path, $options, false, 'all', false], static::$hook);
    }

    /**
     * @param string $path
     * @param array $options
     */
    public function styleCdn(string $path, array $options = []): void
    {
        self::$enqueueManager->register([$path, $options, false, 'all', true], static::$hook);
    }

    /**
     * @param string $handle
     * @param string $objectName
     * @param $data
     */
    public function localizeScript(string $handle, string $objectName, $data): void
    {
        self::$enqueueManager->register(
            [$handle, $objectName, $data, static::$hook],
            static::$hook,
            'localizeScript'
        );
    }

    /**
     * @param string $data
     * @param array $option
     */
    public function inlineScript(string $data, array $option = []): void
    {
        self::$enqueueManager->register([$data, $option], static::$hook, 'inlineScript');
    }

    /**
     * @param string $data
     * @param string $handle
     */
    public function inlineStyle(string $data, string $handle = ''): void
    {
        self::$enqueueManager->register([$data, $handle], static::$hook, 'inlineStyle');
    }

    /**
     * @param string $filePath
     * @param int $port
     */
    public function hotScript(string $filePath, int $port = 8080): void
    {
        $path = 'http://localhost:' . $port . '/assets/' . $filePath;
        wp_enqueue_script('hot-' . uniqid(), $path, [], false, true);
    }
}


