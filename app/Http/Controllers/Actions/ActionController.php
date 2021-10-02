<?php

namespace PluginMaster\App\Http\Controllers\Actions;

use PluginMaster\Bootstrap\System\Controller;
use PluginMaster\Bootstrap\System\Helpers\View;

class ActionController extends Controller
{

    public function __invoke( $request ) {
        View::render( "index", [ "title" => "This is PluginMaster for creating plugin in better way." ] );
    }


}
