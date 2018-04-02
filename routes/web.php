<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->make('view')->make('index');
});

$router->group(['prefix' => 'domains', 'as' => 'domains'], function () use ($router) {
    $router->post('/', ['as' => 'store', 'uses' => 'DomainController@store']);
    $router->get('/{id}',['as' => 'show', 'uses' => 'DomainController@show']);

});

