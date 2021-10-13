<?php


namespace PluginMaster\Bootstrap\System;


use PluginMaster\Bootstrap\System\Helpers\App;
use PluginMaster\Contracts\Enqueue\EnqueueInterface;
use PluginMaster\Foundation\Enqueue\EnqueueHandler;

class Enqueue implements EnqueueInterface
{

    /**
     * @var null
     */
    private static $instance = null;

    /**
     * @var null
     */
    private static $enqueueManager = null;

    /**
     * @var null
     */
    private static $hook = null;

    /**
     * @return Enqueue
     */
    public static function front()
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
    public static function admin()
    {
        static::$hook = 'admin_enqueue_scripts';
        return static::getInstance();
    }

    /**
     * @param $hook
     * @return Enqueue
     */
    public static function on($hook)
    {
        static::$hook = $hook;
        return static::getInstance();
    }

    /**
     * @param $path
     * @param  array  $options
     */
    public function headerScript($path, $options = [])
    {
        self::$enqueueManager->register([
            'options' => $options, 'path' => $path, 'script' => true, 'in_footer' => false, 'hook' => static::$hook
        ]);
    }

    /**
     * @param $path
     * @param  array  $options
     */
    public function headerScriptCdn($path, $options = [])
    {
        self::$enqueueManager->register([
            'options' => $options, 'path' => $path, 'script' => true, 'in_footer' => false, 'cdn' => true,
            'hook'    => static::$hook
        ]);
    }

    /**
     * @param $path
     * @param  array  $options
     */
    public function footerScript($path, $options = [])
    {
        self::$enqueueManager->register([
            'options' => $options, 'path' => $path, 'script' => true, 'in_footer' => true, 'hook' => static::$hook
        ]);
    }

    /**
     * @param $path
     * @param  array  $options
     */
    public function footerScriptCdn($path, $options = [])
    {
        self::$enqueueManager->register([
            'options' => $options, 'path' => $path, 'script' => true, 'in_footer' => true, 'cdn' => true,
            'hook'    => static::$hook
        ]);
    }

    /**
     * @param $path
     * @param  array  $options
     */
    public function style($path, $options = [])
    {
        self::$enqueueManager->register(['options' => $options, 'path' => $path, 'hook' => static::$hook]);
    }

    /**
     * @param $path
     * @param  array  $options
     */
    public function styleCdn($path, $options = [])
    {
        self::$enqueueManager->register([
            'options' => $options, 'path' => $path, 'cdn' => true, 'hook' => static::$hook
        ]);
    }

    /**
     * @param $handler
     * @param $objectName
     * @param $data
     */
    public function localizeScript($handle, $objectName, $data)
    {
        self::$enqueueManager->register([
            'param' => [$handle, $objectName, $data], 'type' => 'localizeScript', 'hook' => static::$hook
        ]);
    }

    /**
     * @param $data
     * @param  array  $option
     */
    public function inlineScript($data, $option = [])
    {
        self::$enqueueManager->register([
            'param' => [$data, $option], 'type' => 'inlineScript', 'hook' => static::$hook
        ]);
    }

    /**
     * @param $data
     * @param  string  $handle
     */
    public function inlineStyle($data, $handle = '')
    {
        self::$enqueueManager->register([
            'param' => [$data, $handle], 'type' => 'inlineStyle', 'hook' => static::$hook
        ]);
    }

}


