<?php

namespace App\system\session;

class Session
{

    public static function unsetFlashSession()
    {
        foreach ($_SESSION as $key => $value) {
            if (strpos($key, 'plugin_master_flash_') === 0) {
                unset ($_SESSION[$key]);
            }
        }
    }

    public static function flush($key, $message = null)
    {
        if ($message) {
            $_SESSION["plugin_master_flash_" . $key] = $message;
            return true;
        } else {
            return $_SESSION["plugin_master_flash_" . $key] ? $_SESSION["plugin_master_flash_" . $key] : '';
        }

    }

    public static function set($name, $message)
    {
        $_SESSION[$name] = $message;
        return (new self) ;
    }

    public static function get($key)
    {
        return  $_SESSION[$key];

    }



    public static function forget($key)
    {
        unset($_SESSION[$key]);
    }

}
