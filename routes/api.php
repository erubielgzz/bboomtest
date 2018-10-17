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

Route::get('images', 'API\ImagesController@index');
Route::get('images/{id}', 'API\ImagesController@getImage');
Route::post('images', 'API\ImagesController@upload');
Route::delete('images/{id}', 'API\ImagesController@delete');
