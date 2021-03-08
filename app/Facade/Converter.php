<?php


namespace App\Facade;


use Illuminate\Support\Facades\Facade;

class Converter extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'Converter';
    }
}
