<?php

namespace App\system\core\base;

interface  Enqueue
{
    public function hotScript($fileName, $port);

    public function csrfToken($handler, $objectName);

    public function footerScript($path, $id);

    public function footerScriptCdn($path, $id);

    public function headerScript($path, $id);

    public function headerScriptCdn($path, $id);

    public function style($path);

    public function styleCdn($path);

}
