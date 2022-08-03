<?php


use PluginMaster\Bootstrap\System\SideMenu;


SideMenu::parent('Demo Plugin')
    ->menuTitle("Home | Demo Plugin")
    ->callback('SideMenuController@index')
    ->child('demo-plugin-home')->callback('SideMenuController@index') ;

SideMenu::submenu('demo-plugin', 'about')->callback('SideMenuController@about');