<?php

namespace App\Facade;

use Illuminate\Support\Facades\Facade;


class HtmlParser extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'HtmlParser';
    }
}
