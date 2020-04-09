<?php

namespace App\controller\api;

use App\system\controller\Controller;
use App\system\db\builder\DB;
use App\system\schema\Schema;


class DashboardController extends Controller
{

    function dashboard($param)
    {


        return [
            "id" => $param['id'],
            "config" => config('environment') === 'local' ? config('endpoints.summery') : config('production_endpoints.summery')
        ];
    }


    public function create($tableName, $sql, $charset_collate)
    {
        global $table_prefix, $wpdb;

         $table = $table_prefix . "$tableName";


        if ($wpdb->get_var("show tables like '$table'") != $table) {

            $finalSql = $sql . $charset_collate;
            $this->execute($finalSql);
        }
    }

    public function execute($sql)
    {
        require_once(ABSPATH . '/wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }


}
