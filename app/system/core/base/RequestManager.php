<?php


namespace App\system\core\base;


interface RequestManager
{

    public function requestInit();

    public function postDataSet();

    public function ajaxDataSet();

    public function getDataSet();

    public function all();

    public function get($property);

    public function __get($property);


}
