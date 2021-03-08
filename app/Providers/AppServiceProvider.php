<?php

namespace App\Providers;

use App\Helper\Converter;
use Illuminate\Support\ServiceProvider;
use App\Helper\HtmlParser;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('HtmlParser', function(){return new HtmlParser();});
        $this->app->bind('Converter', function(){return new Converter();});
    }
}
