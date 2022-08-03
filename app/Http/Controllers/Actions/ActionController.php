<?php

namespace PluginMaster\App\Http\Controllers\Actions;

use PluginMaster\Bootstrap\System\Controller;
use PluginMaster\Bootstrap\System\Helpers\View;

class ActionController extends Controller
{

    public function __invoke($request)
    {
        View::render("index", ["title" => "This message from PluginMaster Action."]);
    }


}
