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

Route::post('login', 'Api\LoginController@login');
Route::get('logout', 'Api\LoginController@logout')->middleware('auth:api');

Route::get('hackathon', 'Api\HackathonController@index')->middleware('auth:api');
Route::get('hackathon/{id}', 'Api\HackathonController@show')->middleware('auth:api');

