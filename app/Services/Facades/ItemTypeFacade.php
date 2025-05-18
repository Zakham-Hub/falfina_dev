<?php

namespace App\Services\Facades;

use Illuminate\Support\Facades\Facade;

class ItemTypeFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'ItemTypeService';
    }
}
