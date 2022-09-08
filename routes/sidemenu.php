<?php


use PluginMaster\Bootstrap\System\SideMenu;


SideMenu::parent('plugin-master')
    ->menuTitle("Home | Plugin Master")
    ->child('Home','pluginmaster-home')->callback('SideMenuController@home') ;

SideMenu::submenu('plugin-master', 'About', 'pluginmaster-about')->callback('SideMenuController@about');