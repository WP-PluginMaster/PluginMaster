<?php

use App\system\core\ConfigHandler;
use App\system\core\ViewHandler;
use App\system\session\Session;


/**
 * @param $path
 * @param array $data
 * @return ViewHandler
 */
function view($path, $data = [])
{
    return ViewHandler::makeView($path, $data);
}


/**
 * @param $data
 * @param int $status
 */
function json($data, $status = 200)
{
    wp_send_json($data, $status);
}


/**
 * @param $key
 * @return mixed
 */
function config($key)
{
    $config = ConfigHandler::init();
    return $config->get($key);
}


/**
 * @param $key
 * @param null $value
 * @return bool|mixed
 */
function session($key, $value = null)
{
    if ($value) {
        Session::set($key, $value);
        return true;
    } else {
        return Session::get($key);
    }

}

/**
 * @param $key
 * @param null $value
 * @return bool|mixed|string
 */
function session_flush($key, $value = null)
{
    if ($value) {
        Session::flush($key, $value);
        return true;
    } else {
        return Session::flush($key);
    }

}


/**
 * @return array|bool|mixed|string
 */
function formErrors()
{
    return Session::flush('errors') ? Session::flush('errors') : [];
}

/**
 * @param $key
 * @return string
 */
function formError($key)
{
    if ($key) {
        return isset(Session::flush('errors')[$key]) ? Session::flush('errors')[$key] : '';
    }
}

/**
 * @return string
 */
function current_url()
{
    return $actual_link = htmlspecialchars((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");

}


