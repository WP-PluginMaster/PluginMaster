<?php

global $mainMenu ; ;


function view($path)
{
    require_once plugin_dir_path(__FILE__) . '../../resources/view/' . $path . '.php';
}


function sidenav_file($routeObject)
{
    $sidenav = $routeObject;
    require_once plugin_dir_path(__FILE__) . '../../routes/sidenav.php';
}

function enqueue_file($enqueueObject)
{
    $enqueue = $enqueueObject;
    require_once plugin_dir_path(__FILE__) . '../../enqueue/enqueue.php';
}


function json($data, $status = 200)
{
    wp_send_json($data, $status);
}


function config($key)
{
    $config = \App\system\core\ConfigHandler::init();
    return $config->get($key);
}


