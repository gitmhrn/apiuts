<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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

$router->post('/users', 'UserController@store');
$router->post('/register', 'AuthController@register');
$router->post('/login', 'AuthController@login');
$router->post('/apikey/request', 'ApiKeyController@create');
$router->group(['middleware' => 'auth.apikey'], function () use ($router) {
    $router->get('/products', 'ProductController@index');
    $router->get('/products/{id}', 'ProductController@show');
    $router->post('/products', 'ProductController@store');
    $router->put('/products/{id}', 'ProductController@update');
    $router->delete('/products/{id}', 'ProductController@destroy');

    $router->get('/recommendations', 'RecommendationController@index');
    $router->get('/recommendations/{id}', 'RecommendationController@show');
    $router->post('/recommendations', 'RecommendationController@store');
    $router->put('/recommendations/{id}', 'RecommendationController@update');
    $router->delete('/recommendations/{id}', 'RecommendationController@destroy');

    $router->get('/recommendation-result', 'RecommendationController@get');
});

