<?php

namespace App\Services\Facades;

use Illuminate\Support\Facades\Facade;

class SizeFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'SizeService';
    }
}
