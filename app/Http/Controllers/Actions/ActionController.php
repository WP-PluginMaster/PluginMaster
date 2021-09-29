<?php

namespace PluginMaster\App\Http\Controllers\Actions;

use PluginMaster\Bootstrap\System\Controller;
use PluginMaster\Bootstrap\System\Helpers\App;

class ActionController extends Controller
{

    public function __invoke( $request ) {
        App::view( "index", [ "title" => "This is PluginMaster for creating plugin in better way." ] );
    }


}
