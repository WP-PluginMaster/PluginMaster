<?php


use PluginMaster\Bootstrap\System\SideMenu;

SideMenu::parent(
    'DemoPlugin',
    ['title' => "Plugin Master", "icon" => "dashicons-admin-site", "as" => 'SideMenuController@index'],
    function () {
        SideMenu::child('DemoPlugin#home', ["title" => "Dashboard", "as" => 'SideMenuController@index']);
    }
);



