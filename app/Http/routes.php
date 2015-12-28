<?php

use Slynova\Commentable\Models\Comment;

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

Route::get('profile',
    ['middleware' => 'auth', 'uses' => 'UserController@getProfile']);

Route::get('/add-game',
    ['as' => 'add-game', 'middleware' => 'auth', 'uses' => 'GameController@getAddGame']);
Route::post('/add-game',
    ['as' => 'add-game', 'middleware' => 'auth',  'uses' => 'GameController@postAddGame']);

Route::get('/add-version/{game_slug}',
    ['as' => 'add-version', 'middleware' => ['auth', 'owngame'], 'uses' => 'GameController@getAddVersion']);
Route::post('/add-version/{game_slug}',
    ['as' => 'add-version', 'middleware' => ['auth', 'owngame'], 'uses' => 'GameController@postAddVersion']);

Route::get('/game/{game_slug}/{version_slug?}',
    ['as' => 'getGame', 'uses' => 'GameController@getGame']);

Route::post('/like/{game_slug}',
    ['as' => 'like', 'middleware' => 'auth', 'uses' => 'GameController@addLike']);

Route::get('/add-comment/{game_slug}',
    ['as' => 'add-comment', 'middleware' => 'auth', 'uses' => 'CommentController@getAddComment']); //so users not logged in get redirected

Route::get('/add-comment-reply/{comment_id}',
    ['as' => 'add-comment-reply', 'middleware' => 'auth', 'uses' => 'CommentController@getAddCommentReply']); //so users not logged in get redirected

Route::post('/add-comment/{game_slug}',
    ['as' => 'add-comment', 'middleware' => 'auth', 'uses' => 'CommentController@postAddComment']);

Route::post('/add-comment-reply/{comment_id}',
    ['as' => 'add-comment-reply', 'middleware' => 'auth', 'uses' => 'CommentController@postAddCommentReply']);

Route::bind('game_slug', function($value, $route) {
    $game = App\Game::whereSlug($value)->first();
    if($game) return $game; //if game is found
    App::abort(404); //game not found
});

Route::bind('comment_id', function($value, $route) {
    return Comment::findOrFail($value);
});


