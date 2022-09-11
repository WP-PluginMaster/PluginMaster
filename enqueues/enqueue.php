<?php

use PluginMaster\Bootstrap\System\Enqueue;

Enqueue::admin()->script('js/react/app.js')->inFooter();
Enqueue::admin()->script('js/js/vue/app.js')->inFooter();

Enqueue::admin()->script('css/app.css')->version(time())->inFooter();




