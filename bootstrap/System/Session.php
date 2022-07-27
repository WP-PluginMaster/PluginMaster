<?php


namespace PluginMaster\Bootstrap\System;

use PluginMaster\Contracts\Session\SessionInterface;

class Session implements SessionInterface
{
    private static $flashKey;

    /**
     * remove onetime/flush session
     */
    public static function destroyFlush(): void
    {
        if (isset($_SESSION[static::getFlushKey()]['flush'])) {
            unset ($_SESSION[static::getFlushKey()]['flush']);
        }
    }

    /**
     * get flush key from application slug
     * @return mixed
     */
    private static function getFlushKey()
    {
        if (!static::$flashKey) {
            static::$flashKey = Config::get('app.slug');
        }
        return static::$flashKey;
    }

    /**
     * set & get flush session
     * if not pass message then return session data with key
     * @param $key
     * @param  null  $message
     * @return void
     */
    public static function flush($key, $message = null): void
    {
        if ($message) {
            $_SESSION[static::getFlushKey()]['flush'][$key] = $message;
        } else {
            $_SESSION[static::getFlushKey()]['flush'][$key] ?? '';
        }
    }

    public static function set(string $name, mixed $message): void
    {
        $_SESSION[static::getFlushKey()][$name] = $message;
    }

    public static function get(string $key): mixed
    {
        return $_SESSION[static::getFlushKey()][$key] ?? null;
    }

    public static function forget(string $key): void
    {
        unset($_SESSION[static::getFlushKey()][$key]);
    }

}
