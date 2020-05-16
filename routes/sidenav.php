<?php

/**
 *  sidenav deceleration system
 * -----for main method :-----
 * first parameter is Menu Slug / Title, second parameter is menu options like :icon, controller & method name , position, page title, remove first submenu)
 * First parameter is Required
 * Required options for second parameter : icon, as (controller and method)
 *
 * -----for sub method :-----
 * first parameter is Menu Slug / Title, second parameter is menu options like :page title, controller & method
 * First parameter is required *
 * Required options for second parameter :  as (controller and method)
 *
 */

$sidenav->main('PluginMaster', ["icon" => "dashicons-admin-site",  "as" => 'NotesController@index',  "removeFirstSubmenu" => true], function ($route) {
    $route->sub('PluginMaster#/Home', ["title" => "Home", "as" => 'NotesController@index']);
    $route->sub('PluginMaster#/Notes', ["title" => "Notes", "as" => 'NotesController@index']);
});

