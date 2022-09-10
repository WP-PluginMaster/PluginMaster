<?php

namespace PluginMaster\App\Http\Controllers\Shortcodes;

use PluginMaster\Bootstrap\System\Controller;

class ShortcodeController extends Controller
{

    public function index()
    {
        echo '<pre>This message from PluginMaster ShortCode. <a href="https://wppluginmaster.com">read more..</a></pre>';
    }

}
