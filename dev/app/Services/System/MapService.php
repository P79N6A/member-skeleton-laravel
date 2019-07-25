<?php

namespace App\Services\System;

class MapService
{
    private $invalidKeys = ['get'];

    public function get($key)
    {
        $status = in_array($key, array_keys(get_class_vars(get_class())));
        if (!$status) {
            throw new \Exception('不合法的Key:'.$key);
        } else {
            return $this->$key;
        }
    }


    public $mapDemo = ['demo'];
}
