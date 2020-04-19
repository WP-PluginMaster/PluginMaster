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
        global $plugin_path;

        if (count($data)) {
            extract($data);
        }

      //  $session = new Session() ;

        include  $plugin_path . '/resources/view/' . $path . '.php';

    }


}
