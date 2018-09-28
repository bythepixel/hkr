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
Route::post('hackathon', 'Api\HackathonController@create')->middleware('auth:api');
Route::get('hackathon/{id}', 'Api\HackathonController@show')->middleware('auth:api');

Route::post('idea', 'Api\IdeaController@create')->middleware('auth:api');
Route::post('idea/{id}/votes', 'Api\IdeaController@getVotes')->middleware('auth:api');

Route::post('ideaVote', 'Api\IdeaVoteController@create')->middleware('auth:api');
Route::delete('ideaVote/{id}', 'Api\IdeaVoteController@delete')->middleware('auth:api');

Route::post('ideaMessage', 'Api\IdeaMessageController@create')->middleware('auth:api');
