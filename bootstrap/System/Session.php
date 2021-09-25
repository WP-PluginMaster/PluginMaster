<?php


namespace PluginMaster\Bootstrap\System;

use PluginMaster\Contracts\Session\SessionInterface;

class Session implements SessionInterface
{
    private static $flashKey;

    public static function destroyFlush() {
       if( isset( $_SESSION[ static::getFlushKey()]['flush'] ) ) unset ( $_SESSION[ static::getFlushKey() ]['flush'] );
    }

    private static function getFlushKey() {
        if ( !static::$flashKey ) static::$flashKey = Config::get( 'app.slug' );
        return static::$flashKey;
    }

    public static function flush( $key, $message = null ) {
        if ( $message ) {
            $_SESSION[ static::getFlushKey() ]['flush'][ $key ] = $message;
            return true;
        } else {
            return $_SESSION[ static::getFlushKey() ]['flush'][ $key ] ?? '';
        }
    }

    public static function set( $name, $message ) {
        $_SESSION[ static::getFlushKey() ][ $name ] = $message;
    }

    public static function get( $key ) {
        return $_SESSION[ static::getFlushKey() ][ $key ] ?? null;
    }


    public static function forget( $key ) {
        unset( $_SESSION[ static::getFlushKey() ][ $key ] );
    }

}
