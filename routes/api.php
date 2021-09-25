<?php


use PluginMaster\App\Controllers\Api\ApiController;
use PluginMaster\Bootstrap\System\Api;


Api::group(['middleware' => 'test'], function(){
    Api::get('test/{id}',ApiController::class);
  //  Api::dynamic('test-data/{id}','TestController@index');
});
