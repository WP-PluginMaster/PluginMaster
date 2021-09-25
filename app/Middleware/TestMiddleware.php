<?php

namespace PluginMaster\App\Middleware;

use PluginMaster\Contracts\Middleware\MiddlewareInterface;

class TestMiddleware implements MiddlewareInterface
{

    public function handler( \WP_REST_Request $request ) {
        return $request->get_method() == 'GET';
    }

}
