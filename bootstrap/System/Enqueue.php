<?php


namespace PluginMaster\Bootstrap\System;


use PluginMaster\Bootstrap\System\Helpers\App;
use PluginMaster\Contracts\Enqueue\EnqueueInterface;
use PluginMaster\Foundation\Enqueue\EnqueueHandler;

class Enqueue implements EnqueueInterface
{

    /**
     * @var bool
     */
    protected static $admin = false;

    /**
     * @var null
     */
    private static $instance = null;


    /**
     * @var null
     */
    private static $enqueueManager = null;

    /**
     * @return Enqueue
     */
    public static function front() {
        static::$admin = false;
        return self::getInstance();
    }

    /**
     * @return Enqueue|null
     */
    private static function getInstance() {
        if ( null === self::$instance ) {
            self::$instance       = new self();
            self::$enqueueManager = App::get( EnqueueHandler::class );
        }

        return self::$instance;
    }

    /**
     * @return Enqueue
     */
    public static function admin() {
        static::$admin = true;
        return static::getInstance();
    }

    /**
     * @param $path
     * @param array $options
     */
    public function headerScript( $path, $options = [] ) {
        self::$enqueueManager->register( [ $path, $options, true, false, false ], static::$admin );
    }

    /**
     * @param $path
     * @param array $options
     */
    public function headerScriptCdn( $path, $options = [] ) {
        self::$enqueueManager->register( [ $path, $options, true, false, true ], static::$admin );
    }

    /**
     * @param $path
     * @param array $options
     */
    public function footerScript( $path, $options = [] ) {
        self::$enqueueManager->register( [ $path, $options, true, true, false ], static::$admin );
    }

    /**
     * @param $path
     * @param array $options
     */
    public function footerScriptCdn( $path, $options = [] ) {
        self::$enqueueManager->register( [ $path, $options, true, true, true ], static::$admin );
    }

    /**
     * @param $path
     * @param array $options
     */
    public function style( $path, $options = [] ) {
        self::$enqueueManager->register( [ $path, $options, false, 'all', false ], static::$admin );
    }

    /**
     * @param $path
     * @param array $options
     */
    public function styleCdn( $path, $options = [] ) {
        self::$enqueueManager->register( [ $path, $options, false, 'all', true ], static::$admin );
    }

    /**
     * @param $handle
     * @param $objectName
     * @param $data
     */
    public function localizeScript( $handle, $objectName, $data ) {
        self::$enqueueManager->register( [ $handle, $objectName, $data, static::$admin ], static::$admin, 'localizeScript' );
    }

    /**
     * @param $data
     * @param array $option
     */
    public function inlineScript( $data, $option = [] ) {
        self::$enqueueManager->register( [ $data, $option ], static::$admin, 'inlineScript' );
    }

    /**
     * @param $data
     * @param string $handle
     */
    public function inlineStyle( $data, $handle = '' ) {
        self::$enqueueManager->register( [ $data, $handle ], static::$admin, 'inlineStyle' );
    }

    /**
     * @param $filePath
     * @param int $port
     */
    public function hotScript( $filePath, $port = 8080 ) {
        $path = 'http://localhost:' . $port . '/assets/' . $filePath;
        wp_enqueue_script( 'hot-' . uniqid(), $path, [], false, true );
    }

}


