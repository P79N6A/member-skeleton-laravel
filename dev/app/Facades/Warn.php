<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class Warn extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'WarnService';
    }
}
