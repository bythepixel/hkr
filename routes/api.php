<?php

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
Route::get('hackathon/{id}/{sort}/{filter}', 'Api\HackathonController@show')->middleware('auth:api');
Route::get('hackathon/reset/{id}', 'Api\HackathonController@reset')->middleware('auth:api');
Route::get('hackathon/delete/{id}', 'Api\HackathonController@delete')->middleware('auth:api');
Route::get('hackathon/lock/{id}', 'Api\HackathonController@lock')->middleware('auth:api');
Route::get('hackathon/unlock/{id}', 'Api\HackathonController@unlock')->middleware('auth:api');

Route::post('idea', 'Api\IdeaController@create')->middleware('auth:api');
Route::get('idea/{id}/votes', 'Api\IdeaController@getVotes')->middleware('auth:api');
Route::get('idea/{id}/favorites', 'Api\IdeaController@getFavorites')->middleware('auth:api');
Route::get('idea/{id}', 'Api\IdeaController@show')->middleware('auth:api');
Route::get('idea/{id}/delete', 'Api\IdeaController@destroy')->middleware('auth:api');
Route::get('idea/{id}/archive', 'Api\IdeaController@archive')->middleware('auth:api');
Route::get('idea/{id}/restore', 'Api\IdeaController@restore')->middleware('auth:api');

Route::post('ideaVote', 'Api\IdeaVoteController@create')->middleware('auth:api');
Route::delete('ideaVote/{id}', 'Api\IdeaVoteController@delete')->middleware('auth:api');
Route::delete('ideaVote/deleteByUserAndIdea/{ideaId}', 'Api\IdeaVoteController@deleteByUserAndIdea')->middleware('auth:api');

Route::post('ideaFavorite', 'Api\IdeaFavoriteController@create')->middleware('auth:api');
Route::post('ideaFavorite', 'Api\IdeaFavoriteController@create')->middleware('auth:api');
Route::delete('ideaFavorite/deleteByUserAndIdea/{ideaId}', 'Api\IdeaFavoriteController@deleteByUserAndIdea')->middleware('auth:api');

Route::post('ideaMessage', 'Api\IdeaMessageController@create')->middleware('auth:api');

Route::get('user', 'Api\UserController@index')->middleware('auth:api');
Route::post('user/copy-idea', 'Api\UserController@copyIdea')->middleware('auth:api');

Route::post('user', 'Api\UserController@create'); // TOP SECRET
