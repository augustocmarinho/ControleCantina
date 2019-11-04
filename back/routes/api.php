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

// ROTAS PRODUTOS
Route::group(['prefix' => 'produtos', 'middleware' => ['auth:api']], function () {
    Route::post('/create', "Api\ProdutosController@create");
    Route::post('/update', "Api\ProdutosController@update");
    Route::get('/get', "Api\ProdutosController@get");
    Route::get('/getAll', "Api\ProdutosController@getAll");
    Route::post('/delete', "Api\ProdutosController@delete");
});

Route::group(['prefix' => 'funcionarios'], function(){
    Route::get('/', 'UserController@index');
    Route::get('/{funcionario}', 'UserController@show');
    Route::get('/search/{termo}', 'UserController@search');
    Route::post('', 'UserController@store');
    Route::put('/{funcionario}', 'UserController@update');
    Route::delete('/{funcionario}', 'UserController@delete');
});

// ROTAS CLIENTES
Route::group(['prefix' => 'clientes', 'middleware' => ['auth:api']], function () {
    Route::post('/create', "Api\ClientesController@create");
    Route::post('/update', "Api\ClientesController@update");
    Route::get('/get', "Api\ClientesController@get");
    Route::get('/getAll', "Api\ClientesController@getAll");
    Route::post('/delete', "Api\ClientesController@delete");
});
