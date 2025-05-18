<?php

namespace App\Services\Facades;

use Illuminate\Support\Facades\Facade;

class CategoryFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'CategoryService';
    }
}
