<?php


use PluginMaster\App\Http\Controllers\Api\ApiController;
use PluginMaster\Bootstrap\System\Api;


Api::group(['middleware' => 'test'], function(){
    Api::get('test/{id}',ApiController::class);
});
