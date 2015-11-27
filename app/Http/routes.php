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

Route::get('/login',
    ['as' => 'login', 'uses' => 'UserController@getLogin']);

Route::post('/',
    ['as' => '/', 'uses' => 'HomeController@postHome']);

Route::get('/add-game',
    ['as' => 'add-game', 'uses' => 'GameController@getAddGame']);

Route::post('/add-game',
    ['as' => 'add-game', 'uses' => 'GameController@postAddGame']);

Route::get('/game/{game_slug}/{version?}',
    ['as' => 'post', 'uses' => 'GameController@getGame']);

Route::post('/favorite/{game_slug}',
    ['as' => 'favorite', 'uses' => 'GameController@addFavorite']);

Route::bind('game_slug', function($value, $route) {
    $game = App\Game::whereSlug($value)->first();
    if($game) return $game; //if game is found
    App::abort(404); //game not found
});