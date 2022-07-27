<?php


namespace PluginMaster\Bootstrap\System;


use PluginMaster\Bootstrap\System\Helpers\App;
use PluginMaster\Contracts\Enqueue\EnqueueInterface;
use PluginMaster\Foundation\Enqueue\EnqueueHandler;

class Enqueue implements EnqueueInterface
{

    /**
     * @var Enqueue|null
     */
    private static ?self $instance = null;

    /**
     * @var EnqueueHandler|null
     */
    private static ?EnqueueHandler $enqueueManager = null;

    /**
     * @var null
     */
    private static $hook = null;

    /**
     * @return Enqueue
     */
    public static function front(): self
    {
        static::$hook = 'wp_enqueue_scripts';
        return self::getInstance();
    }

    /**
     * @return Enqueue|null
     */
    private static function getInstance()
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
        static::$hook = 'admin_enqueue_scripts';
        return static::getInstance();
    }

    /**
     * @param  string  $hook
     * @return Enqueue
     */
    public static function on(string $hook): self
    {
        static::$hook = $hook;
        return static::getInstance();
    }

    /**
     * @param  string  $path
     * @param  array  $options
     */
    public function headerScript(string $path, array $options = []): void
    {
        self::$enqueueManager->register([
            'options' => $options,
            'path' => $path,
            'script' => true,
            'in_footer' => false,
            'hook' => static::$hook
        ]);
    }

    /**
     * @param  string  $path
     * @param  array  $options
     */
    public function headerScriptCdn(string $path, array $options = []): void
    {
        self::$enqueueManager->register([
            'options' => $options,
            'path' => $path,
            'script' => true,
            'in_footer' => false,
            'cdn' => true,
            'hook' => static::$hook
        ]);
    }

    /**
     * @param  string  $path
     * @param  array  $options
     */
    public function footerScript(string $path, array $options = []): void
    {
        self::$enqueueManager->register([
            'options' => $options,
            'path' => $path,
            'script' => true,
            'in_footer' => true,
            'hook' => static::$hook
        ]);
    }

    /**
     * @param  string  $path
     * @param  array  $options
     */
    public function footerScriptCdn(string $path, array $options = []): void
    {
        self::$enqueueManager->register([
            'options' => $options,
            'path' => $path,
            'script' => true,
            'in_footer' => true,
            'cdn' => true,
            'hook' => static::$hook
        ]);
    }

    /**
     * @param  string  $path
     * @param  array  $options
     */
    public function style(string $path, array $options = []): void
    {
        self::$enqueueManager->register(['options' => $options, 'path' => $path, 'hook' => static::$hook]);
    }

    /**
     * @param  string  $path
     * @param  array  $options
     */
    public function styleCdn(string $path, array $options = []): void
    {
        self::$enqueueManager->register([
            'options' => $options,
            'path' => $path,
            'cdn' => true,
            'hook' => static::$hook
        ]);
    }

    /**
     * @param  string  $handle
     * @param  string  $objectName
     * @param  mixed  $data
     */
    public function localizeScript(string $handle, string $objectName, mixed $data): void
    {
        self::$enqueueManager->register([
            'param' => [$handle, $objectName, $data],
            'type' => 'localizeScript',
            'hook' => static::$hook
        ]);
    }

    /**
     * @param  string  $data
     * @param  array  $option
     */
    public function inlineScript(string $data, array $option = []): void
    {
        self::$enqueueManager->register([
            'param' => [$data, $option],
            'type' => 'inlineScript',
            'hook' => static::$hook
        ]);
    }

    /**
     * @param  string  $data
     * @param  string  $handle
     */
    public function inlineStyle(string $data, string $handle = ''): void
    {
        self::$enqueueManager->register([
            'param' => [$data, $handle],
            'type' => 'inlineStyle',
            'hook' => static::$hook
        ]);
    }

}


