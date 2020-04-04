<?php
namespace App\middleware;

use App\system\core\Middleware;
use App\system\Request;

class Admin extends Middleware
{


    public function handle( Request $request){

      return json($request->allData) ;

    }

}