<?php

namespace App\controller\api;

use App\system\controller\Controller;
use App\system\core\Settings;


class DashboardController extends Controller
{

    function dashboard($param)
    {
        return [
            "id" => $param['id'],
            "env" => config('environment')
        ];
    }




}
