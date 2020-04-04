<?php


namespace App\system\core\base;


interface Sidenav
{

    public function main($nav, $options, $closure );

    public function  sub($nav, $options);
}
