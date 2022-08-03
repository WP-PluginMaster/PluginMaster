<?php

namespace PluginMaster\App\Http\Middleware;

use PluginMaster\Contracts\Middleware\MiddlewareInterface;
use WP_REST_Request;

class TestMiddleware implements MiddlewareInterface
{

    public function handler(WP_REST_Request $request): bool
    {
        return true;
    }

}
