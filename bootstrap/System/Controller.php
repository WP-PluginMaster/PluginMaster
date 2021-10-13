<?php


namespace PluginMaster\Bootstrap\System;


use PluginMaster\Bootstrap\System\Helpers\App;
use PluginMaster\Request\Request;

class Controller
{
    /**
     * @var Request
     */
    protected $request;

    public function __construct()
    {
        $this->request = App::get()->get(Request::class);
    }


}
