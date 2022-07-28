<?php

namespace PluginMaster\App\Http\Middleware;

use PluginMaster\Contracts\Middleware\MiddlewareInterface;

class TestMiddleware implements MiddlewareInterface
{

    public function handler( \WP_REST_Request $request ) {
        return  true;
    }

}
