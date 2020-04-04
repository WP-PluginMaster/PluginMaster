<?php

namespace App\system\request;

use App\system\core\base\RequestManager;

class Request implements RequestManager
{

    private $all = [];

    function __construct()
    {
        $this->requestInit();
    }

    /**
     *
     * set all requested data as this class property;
     */
    public function requestInit()
    {
        $this->postDataSet();
        $this->ajaxDataSet();
        $this->getDataSet();
    }

    /**
     *set server global data as this class property
     */
    public function postDataSet()
    {
        foreach ($_POST as $key => $value) {
            $this->{$key} = $value;
            $this->all[$key] = $value;
        }

    }

    /**
     *set server global data as this class property
     */
    public function ajaxDataSet()
    {
        $inputJSON = file_get_contents('php://input');
        if ($inputJSON) {
            $input = json_decode($inputJSON, true);
            foreach ($input as $key => $value) {
                $this->{$key} = $value;
                $this->all[$key] = $value;
            }
        }


    }

    /**
     *set server global data as this class property
     */
    public function getDataSet()
    {
        foreach ($_GET as $key => $value) {
            $this->{$key} = $value;
            $this->all[$key] = $value;
        }

    }


    /**
     * set all requested data as this class property;
     */
    public function all()
    {
        return $this->all;
    }

    /**
     * @param $property
     * @return |null
     */
    public function get($property)
    {
        return isset($this->{$property}) ? $this->{$property} : null;
    }


    /**
     * @param $property
     * @return |null
     */
    public function __get($property)
    {
        return isset($this->{$property}) ? $this->{$property} : null;
    }


}
