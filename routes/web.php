<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/items', 'ItemController@index');
Route::get('/items/{searchQuery}', 'ItemController@index');
Route::post('/items', 'ItemController@search');

Route::get('/itemsvue', 'ItemController@indexvue');
Route::get('/api/items', 'ItemController@indexjson');
Route::get('/api/items/{searchQuery}', 'ItemController@indexjson');
