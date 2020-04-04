<?php
namespace App\system\core;

use App\system\Request;

abstract class Middleware
{

    abstract public function handle(Request $request) ;

}