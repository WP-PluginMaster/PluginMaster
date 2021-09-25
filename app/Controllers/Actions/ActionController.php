<?php

namespace PluginMaster\App\Controllers\Actions;

use PluginMaster\Bootstrap\System\Controller;
use PluginMaster\Bootstrap\System\View;

class ActionController extends Controller
{

    public function __invoke( $request ) {
        View::add( "index", [ "title" => "From Action" ] );
    }


}
