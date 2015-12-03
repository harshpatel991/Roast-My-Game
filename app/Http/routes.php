<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/',
    ['as' => 'home', 'uses' => 'HomeController@getHome']);

Route::post('/',
    ['as' => '/', 'uses' => 'HomeController@postHome']);

// Authentication routes...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

// Registration routes...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');

Route::get('profile', 'UserController@getProfile');

Route::get('/add-game',
    ['as' => 'add-game', 'uses' => 'GameController@getAddGame']);

Route::get('/add-version/{game_slug}',
    ['as' => 'add-version', 'uses' => 'GameController@getAddVersion']);

Route::post('/add-game',
    ['as' => 'add-game', 'uses' => 'GameController@postAddGame']);

Route::post('/add-version/{game_slug}',
    ['as' => 'add-version', 'uses' => 'GameController@postAddVersion']);

Route::get('/game/{game_slug}/{version_slug?}',
    ['as' => 'getGame', 'uses' => 'GameController@getGame']);

Route::post('/favorite/{game_slug}',
    ['as' => 'favorite', 'uses' => 'GameController@addFavorite']);

Route::bind('game_slug', function($value, $route) {
    $game = App\Game::whereSlug($value)->first();
    if($game) return $game; //if game is found
    App::abort(404); //game not found
});