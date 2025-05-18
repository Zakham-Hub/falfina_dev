<?php

namespace App\Services\Facades;

use Illuminate\Support\Facades\Facade;

class ItemFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'ItemService';
    }
}
