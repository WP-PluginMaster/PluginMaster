<?php

use PluginMaster\Bootstrap\System\Enqueue;

Enqueue::admin()->script( 'js/app.js' )->inFooter();

Enqueue::admin()->script('css/index.css')->version('123212')->inFooter();




