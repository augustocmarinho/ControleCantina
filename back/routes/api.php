<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/** ROTAS LOGIN **/
Route::post('/login', ['uses' => 'Auth\LoginController@login']);
Route::post('/login/refresh', ['uses' => 'Api\LoginController@refresh']);
Route::get('/logout', ['uses' => 'Api\LoginController@logout', 'middleware' => ['auth:api']]);

// ROTAS USUARIO
Route::group(['prefix' => 'usuario', 'middleware' => ['auth:api']], function () {
    Route::post('/add', "Api\UsuarioController@add");
    Route::get('/getUserCurrent', ['uses' => 'Api\UsuarioController@getUserCurrent']);
    Route::post('/update', ['uses' => 'Api\UsuarioController@update']);
});

Route::group(['prefix' => 'funcionarios'], function(){
    Route::get('/', 'UserController@index');
    Route::get('/{funcionario}', 'UserController@show');
    Route::get('/search/{termo}', 'UserController@search');
    Route::post('', 'UserController@store');
    Route::put('/{funcionario}', 'UserController@update');
    Route::delete('/{funcionario}', 'UserController@delete');
});