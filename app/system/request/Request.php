<?php

namespace App\system\request;

use App\system\Validator;
use PluginMaster\Request\Request as RequestManager;

class Request extends RequestManager
{

    /**
     * can be used for rest route
     * @param $rules | Array
     * @return bool|void
     */
    public function validate($rules)
    {
        $validate = Validator::make($this, $rules);

        if ($validate->fails()) {
            return json([
                "message" => "Validation failed",
                "errors" => $validate->errors()
            ], 400);
        }

        return true;
    }

}
