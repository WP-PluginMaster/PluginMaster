<?php


namespace PluginMaster\Bootstrap\System;

use PluginMaster\Contracts\Session\SessionInterface;

class Session implements SessionInterface
{
    private static string $flashKey = '';

    /**
     * remove onetime/flush session
     */
    public static function destroyFlush(): void
    {
        if (isset($_SESSION[self::getFlushKey()]['flush'])) {
            unset ($_SESSION[self::getFlushKey()]['flush']);
        }
    }

    /**
     * get flush key from application slug
     * @return string
     */
    private static function getFlushKey(): string
    {
        if (!self::$flashKey) {
            self::$flashKey = Config::get('app.slug');
        }
        return self::$flashKey;
    }

    /**
     * set & get flush session
     * if not pass message then return session data with key
     * @param string $key
     * @param null $message
     * @return void
     */
    public static function flush(string $key, $message = null): void
    {
        if ($message) {
            $_SESSION[self::getFlushKey()]['flush'][$key] = $message;
        } else {
            $_SESSION[self::getFlushKey()]['flush'][$key] ?? '';
        }
    }

    public static function set(string $name, $message): void
    {
        $_SESSION[self::getFlushKey()][$name] = $message;
    }

    public static function get(string $key)
    {
        return $_SESSION[self::getFlushKey()][$key] ?? null;
    }


    public static function forget($key): void
    {
        unset($_SESSION[self::getFlushKey()][$key]);
    }

}
