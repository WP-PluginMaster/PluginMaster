<?php

use PluginMaster\Bootstrap\System\Application;
use PluginMaster\Bootstrap\System\Config;
use PluginMaster\Bootstrap\System\Helpers\View;
use PluginMaster\Request\Request;


if ( ! function_exists('pluginmaster_app')) {

    /**
     * Get the available container instance.
     *
     * @param  null  $class
     *
     * @return object|Application
     */

    function pluginmaster_app($class = null)
    {
        if (is_null($class)) {
            return Application::getInstance();
        }

        return Application::getInstance()->get($class);
    }

}


if ( ! function_exists('pluginmaster_config')) {

    /**
     * Get config.
     *
     * @param $key
     *
     * @return mixed
     */

    function pluginmaster_config($key)
    {
        return Config::get($key);
    }

}


if ( ! function_exists('pluginmaster_url')) {

    /**
     * Get config.
     * @return mixed
     */

    function pluginmaster_url()
    {
        return pluginmaster_app()->baseUrl();
    }

}


if ( ! function_exists('pluginmaster_view')) {

    /**
     * Get view file.
     *
     * @param $path
     * @param  array  $data
     * @param  bool  $noTemplate
     *
     * @return mixed
     */

    function pluginmaster_view($path, $data = [], $noTemplate = false)
    {
        return View::render($path, $data, $noTemplate);
    }

}


if ( ! function_exists('pluginmaster_domain')) {

    /**
     * Get text domain / slug.
     */

    function pluginmaster_domain()
    {
        return Config::get('app.slug');
    }

}

if ( ! function_exists('pluginmaster_text')) {

    /**
     * Get translated text.
     *
     * @param $text
     * @param  string  $fn
     *
     * @return mixed
     */

    function pluginmaster_text($text, $fn = '__')
    {
        return $fn($text, Config::get('app.slug'));
    }
}

if ( ! function_exists('pluginmaster_text')) {

    /**
     * Get translated text.
     *
     * @param $text
     * @param  string  $fn
     *
     * @return mixed
     */

    function pluginmaster_text($text, $fn = '__')
    {
        return $fn($text, Config::get('app.slug'));
    }
}

if ( ! function_exists('pluginmaster_text_p')) {

    /**
     * Get translated text and print .
     *
     * @param $text
     * @param  string  $fn
     *
     * @return mixed
     */

    function pluginmaster_text_p($text, $fn = '_e')
    {
        return $fn($text, Config::get('app.slug'));
    }
}


if ( ! function_exists('pluginmaster_title')) {

    /**
     * Get translated title .
     *
     * @param $text
     * @param  string  $fn
     *
     * @return mixed
     */

    function pluginmaster_title($text, $fn = 'esc_html__')
    {
        return $fn($text, Config::get('app.slug'));
    }
}


if ( ! function_exists('pluginmaster_title_p')) {

    /**
     * Get translated title and print .
     *
     * @param $text
     * @param  string  $fn
     *
     * @return mixed
     */

    function pluginmaster_title_p($text, $fn = 'esc_html_e')
    {
        return $fn($text, Config::get('app.slug'));
    }
}


if ( ! function_exists('pluginmaster_request')) {

    /**
     * Retrieve the translation of $text and escapes it for safe use in HTML output.
     *
     * @param $text
     *
     * @return string
     */

    function pluginmaster_request()
    {
        return pluginmaster_app()->get(Request::class);
    }

}

if ( ! function_exists('pluginmaster_api')) {

    /**
     * Retrieve the rest api url.
     *
     * @param  string  $path
     *
     * @return string
     */

    function pluginmaster_api($path = '')
    {
        return get_rest_url('', Config::get('app.api_namespace').($path ? '/'.$path : ''));
    }

}


if ( ! function_exists('pluginmaster_api')) {

    /**
     * Retrieve the translation of $text and escapes it for safe use in HTML output.
     *
     * @param  string  $path
     *
     * @return string
     */

    function pluginmaster_api($path = '')
    {
        return get_rest_url('', Config::get('app.api_namespace').($path ? '/'.$path : ''));
    }

}


if ( ! function_exists('pluginmaster_path')) {

    /**
     *
     * @param  string  $path
     *
     * @return string
     */

    function pluginmaster_path($path)
    {
        return pluginmaster_app()->path($path);
    }

}

if ( ! function_exists('pluginmaster_asset')) {

    /**
     *
     * @param  string  $path
     *
     * @return string
     */

    function pluginmaster_asset($path)
    {
        return pluginmaster_app()->asset($path);
    }

}
