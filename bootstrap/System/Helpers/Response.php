<?php


namespace PluginMaster\Bootstrap\System\Helpers;


class Response
{

    public static function json($data, $status = 200)
    {
        return wp_send_json($data, $status);
    }

}
