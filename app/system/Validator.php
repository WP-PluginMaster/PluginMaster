<?php


namespace App\system;


class Validator
{


    public static $message = [];


    public static function execute($request, $validatorData)
    {

        $status = true;

        foreach ($validatorData as $key => $option) {
            $options = [
                "checkers" => $option,
                "data" => $request->get((string)$key),
                "fieldName" => $key
            ];

            $valueAsArray = explode('|', $options['checkers']);

            foreach ($valueAsArray as $k => $value) {

                $validateOption = [
                    "data" => $options['data'],
                    "fieldName" => $options['fieldName'],
                ];

                $split = explode(':', $value);
                $validateOption['checker'] = $split[0];
                if (count($split) > 1) $validateOption['limit'] = $split[1];


                $check = self::validate($validateOption);

                if (!$check) {
                    $status = false;
                }


            }


        }

        if(!$status){
            return  json( [
                "status" => $status,
                "message" => "Please check required field",
                "errors" => self::$message
            ], 401);
        }

        return $status ;
    }


    public static function validate($options)
    {
        $status = false;
        switch ($options['checker']) {
            case 'required':
                if ($options['data']) $status = true; else array_push(self::$message, $options['fieldName'] . ' is Field is required');
                break;
            case 'mobile':
                if (preg_match("/^[0]/", $options['data']) && preg_match("/^[0-9]*$/", $options['data'])) $status = true; else array_push(self::$message, $options['fieldName'] . ' nust be number and start with 0');
                break;
            case 'number':
                if (preg_match("/^[0-9]*$/", $options['data'])) $status = true; else array_push(self::$message, $options['fieldName'] . ' must be number');
                break;
            case 'floatNumber':
                if (preg_match("/\-?\d+\.\d+/", $options['data'])) $status = true; else array_push(self::$message, $options['fieldName'] . ' must be float number');
                break;
            case 'noNumber':
                if (preg_match("/^([^0-9]*)$/", $options['data'])) $status = true; else array_push(self::$message, $options['fieldName'] . ' must be without number');
                break;
            case 'letter':
                if (preg_match("/^([A-Za-z ]*)$/", $options['data'])) $status = true; else array_push(self::$message, $options['fieldName'] . ' must be letter');
                break;
            case 'noSpecialChar':
                if (!preg_match('/[`~!@#$%^&*()_|+\-=?;:\'",.<>\{\}\/]/', $options['data'])) $status = true; else array_push(self::$message, $options['fieldName'] . ' must be without special character');
                break;
            case 'limit':
                if (preg_match('/^.{' . $options['limit'] . '}$/', $options['data'])) $status = true; else array_push(self::$message, $options['fieldName'] . ' must be within ' . $options['limit'] . ' character');
                break;
            case 'wordLimit':
                $word = explode(" ", $options['data']);
                $limits = explode(",", $options['limit']);
                if (count($word) > $limits[0] && count($word) < $limits[1]) $status = true; else array_push(self::$message, $options['fieldName'] . ' must be word limit: ' . $limits[0] . ' to ' . $limits[1]);
                break;
            case 'email':
                if (preg_match('/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/', $options['data'])) $status = true; else array_push(self::$message, $options['fieldName'] . ' must be a valid email');
                break;

        }

        return $status;
    }

}
