<?php


namespace PluginMaster\Bootstrap\System;


class Response
{

    public static function json( $data, $status = 200 ) {
        wp_send_json( $data, $status );
    }

}
