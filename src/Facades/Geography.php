<?php

namespace DazzaDev\Geography\Facades;

use Illuminate\Support\Facades\Facade;

class Geography extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravel-geography';
    }
}
