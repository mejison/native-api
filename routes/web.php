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

$router->group(['prefix' => 'api'], function() use ($router) {
    $router->group(['prefix' => 'v1'], function() use ($router) {
        $router->group(['prefix' => 'auth'], function()use ($router) {
            $router->post('/login', 'AuthController@login');
            $router->post('/register', 'AuthController@register');
        });

        $router->group(['prefix' => 'post'], function()use ($router) {
            $router->get('/', 'PostController@getAll');
            $router->get('/{id}', 'PostController@getOne');            
            $router->put('/{id}', 'PostController@update');
            $router->delete('/{id}', 'PostController@delete');
        });

        $router->group(['prefix' => 'user'], function() use ($router) {
            $router->post('{user}/post', 'PostController@create');
            $router->get('{user}/post', 'PostController@getByUser');
        });
    });
});