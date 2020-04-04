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

$sidenav->main('DemoPlugin', ["icon" => "dashicons-admin-site",  "as" => 'NotesController@index', "position" => 500, "removeFirstSubmenu" => true], function ($route) {
    $route->sub('DemoPlugin#/Dashboard', ["title" => "Dashboard", "as" => 'NotesController@index']);
    $route->sub('DemoPlugin#/Notes', ["title" => "Notes", "as" => 'NotesController@index']);
});
