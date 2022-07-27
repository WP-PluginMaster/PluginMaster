<?php

namespace PluginMaster\App\Http\Controllers\Api;

use PluginMaster\Bootstrap\System\Controller;
use PluginMaster\Bootstrap\System\Helpers\Response;
use WP_REST_Request;

class ApiController extends Controller
{

    public function __invoke(WP_REST_Request $request)
    {
        return Response::json([
            "url" => $this->request->url(),
            "name" => $request->get_param('name'),
        ]);
    }

    public function getProductsName(WP_REST_Request $request)
    {
        return Response::json([
            "url" => $this->request->url(),
            "name" => $request->get_param('name'),
            "dynamic" => "This is dynamic api",
        ]);
    }

}
