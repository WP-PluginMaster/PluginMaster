<?php


namespace PluginMaster\Bootstrap;


use PluginMaster\Database\Migration;

class Activation
{

    /**
     * fire this method when plugin activate
     * define your functionality here
     */
    public function index(){
        /**
         * run migration
         * @for creating custom table or sql execution
         */
        Migration::handler();
    }


}
