<?php


namespace PluginMaster\Bootstrap\System;


use PluginMaster\Bootstrap\System\Helpers\App;

class View
{

    /**
     * @param $path
     * @param $data
     * @return string
     */
    public static function  add( $path, $data = []) {

        if ( count( $data ) ) {
            extract( $data );
        }

       return  include App::get()->resourcePath( $path . '.php' );

    }


}
