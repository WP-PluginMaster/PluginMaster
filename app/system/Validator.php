<?php

namespace App\system;

use App\system\session\Session;
use PluginMaster\Validator\Validator as RequestValidator;

class Validator extends RequestValidator
{
 
    /**
     * @param $request
     * @param $validatorData
     * @return Validator|RequestValidator
     */
    public static function make($request, $validatorData)
    {
        $self = (new self);
        $self->message = [];
        $self->execute($request, $validatorData);
        return $self;
    }

    /**
     * @return void
     */
    public function flashErrors()
    {
        if ($this->fails()) {
            Session::flush('errors', $this->errors());
        }
    }


}
