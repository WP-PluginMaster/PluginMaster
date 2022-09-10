<?php


use PluginMaster\Bootstrap\System\SideMenu;


SideMenu::parent('plugin-master')
    ->menuTitle("Home | Plugin Master")
    ->child('Home','pluginmaster-home')->callback('SideMenuController@home') ;

SideMenu::submenu('plugin-master', 'React App', 'plugin-master-react')->callback('SideMenuController@react');
SideMenu::submenu('plugin-master', 'Vue App', 'plugin-master-vue')->callback('SideMenuController@vue');