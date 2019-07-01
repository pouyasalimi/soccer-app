<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('auth')->group(function () {
    Route::put('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');
    Route::get('refresh', 'AuthController@refresh');
    Route::group(['middleware' => 'auth:api'], function(){
        Route::get('user', 'AuthController@user');
        Route::post('logout', 'AuthController@logout');
    });
});

Route::group(['middleware' => 'auth:api','prefix' => 'users'], function(){
    Route::get('/', 'UserController@index');
});

Route::group(['middleware' => 'auth:api','prefix' => 'players'], function(){
    Route::get('/', 'PlayerController@index');
    Route::get('/{id}', 'PlayerController@show');
    Route::post('/', 'PlayerController@store');
    Route::put('/{id}', 'PlayerController@update');
    Route::delete('/{id}', 'PlayerController@delete');
    Route::post('/picture', 'PlayerController@picture');
});

Route::group(['middleware' => 'auth:api','prefix' => 'teams'], function(){
    Route::get('/', 'TeamController@index');
    Route::get('/{id}', 'TeamController@show');
    Route::post('/', 'TeamController@store');
    Route::put('/{id}', 'TeamController@update');
    Route::delete('/{id}', 'TeamController@delete');
});

Route::group(['middleware' => 'auth:api','prefix' => 'player/teams'], function(){
    Route::get('/', 'PlayerTeamController@index');
    Route::post('/', 'PlayerTeamController@store');
    Route::delete('/{id}', 'PlayerTeamController@delete');
});
