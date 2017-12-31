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

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', ['namespace' => 'App\Http\Controllers\Api\V1'], function ($api) {
    $api->group(['prefix' => 'v1'], function ($api) {
        $api->group(['prefix' => 'users'], function ($api) {

            $api->get('/', 
                  [ 'as' => 'users.list', 
                    'uses' => 'UserController@index'
            ]);

            $api->get('/{id}',
                [ 'as' => 'users.get', 
                'uses' => 'UserController@findById'
            ]);

            $api->post('/', 
                  [ 'as' => 'users.store', 
                    'uses' => 'UserController@store'
            ]);

            $api->put('/{id}', 
                  [ 'as' => 'users.update', 
                    'uses' => 'UserController@update'
            ]);
        });
    });
});

$router->get('/', function () use ($router) {
    return $router->app->version();
});
