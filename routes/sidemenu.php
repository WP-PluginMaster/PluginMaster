<?php


use PluginMaster\Bootstrap\System\SideMenu;


SideMenu::parent('PluginMaster')
    ->menuTitle("Home | Plugin Master")
    ->child('Home','pluginmaster-home')->callback('SideMenuController@index') ;

SideMenu::submenu('pluginmaster', 'About', 'pluginmaster-about')->callback('SideMenuController@about');