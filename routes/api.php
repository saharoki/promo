<?php
/** @var \Laravel\Lumen\Routing\Router $router */

$router->group([
    'prefix' => 'api'
], function ($router){
    Route::get('promo2mp3', 'MainController@promo2mp3');
    Route::get('mp3/{id}', 'MainController@getMp3');
});
