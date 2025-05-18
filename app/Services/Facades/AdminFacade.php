<?php

namespace App\Services\Facades;

use Illuminate\Support\Facades\Facade;

class AdminFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'AdminService';
    }
}
