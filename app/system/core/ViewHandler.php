<?php


namespace App\system\core;


use App\system\session\Session;

class ViewHandler
{

public $data = "Hello" ;
    /**
     * @param $path
     * @param $data
     * @return ViewHandler
     */
    public static function makeView($path, $data)
    {

        if (count($data)) {
            extract($data);
        }

        include  Settings::$plugin_path . '/resources/view/' . $path . '.php';

    }


}
