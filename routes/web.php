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
    return $router->app->version();
});

$router->group(['prefix' => 'auth'], function () use ($router) {
    $router->post('login',['uses' => 'AuthController@authenticate']);
});

$router->group(['middleware' => 'jwt.auth'], function() use ($router) {
    $router->get('users', 'UserController@index');
    $router->get('users/{id}', 'UserController@showProfile');
    // $router->get('users/my-profile', 'UserController@myProfile');
    $router->patch('users/{id}/update', 'UserController@update');
    $router->patch('users/{id}/update-image', 'UserController@updateImage');
    $router->get('filter-data', 'UserController@dataFilter');
    $router->post('users/filter', 'UserController@filter');
    $router->post('users/search','UserController@search');
});


