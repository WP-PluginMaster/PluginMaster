<?php
namespace  PluginMaster\App\Controllers\Api;

use PluginMaster\Bootstrap\System\Controller;

class ApiController extends Controller
{

    public function __invoke( $request ) {

        echo $this->request->url();
    }

    public function getProductsName($option){
        echo  "Dynamic API data" ;
    }


}
