<?php

use harshpatel991\Commentable\Models\Comment;
use Illuminate\Support\Facades\Auth;


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
    ['uses' => 'HomeController@getHome']);

Route::get('/games',
    ['uses' => 'HomeController@getGames']);

//==========\/ This is now deprecated, can be removed near end of Feb 2016
Route::get('/games/not-yet-roasted', function() {
    return Redirect::to('/games?roasted=false', 301);
});
Route::get('/games/{genre}', function($genre) {
    return Redirect::to('/games?genre='.$genre, 301);
});
Route::get('/games/by_platform/{platform}', function($platform) {
    return Redirect::to('/games?platform='.$platform, 301);
});
Route::bind('platform', function($value, $route) {
    if(in_array($value, App\Game::$platforms)) {
        return $value; //if platform is found
    }
    App::abort(404); //platform not found
});
Route::bind('genre', function($value, $route) {
    if(array_key_exists($value, App\Game::$genres)) {
        return $value; //if genre is found
    }
    App::abort(404); //genre not found
});
//==========^ This is now deprecated, can be removed near end of Feb 2016

Route::post('/',
    ['uses' => 'HomeController@postHome']);


Auth::routes();
Route::get('auth/login', 'Auth\LoginController@showLoginForm');
Route::post('auth/login', 'Auth\LoginController@login');
Route::get('auth/logout', 'Auth\LoginController@logout');

Route::get('/register-success', 'UserController@registerSuccess');
Route::get('/verify/{confirmation_code}', 'UserController@verifySuccess');

// Registration routes...
Route::get('auth/register', 'Auth\RegisterController@showRegistrationForm');
Route::post('auth/register', 'Auth\RegisterController@register');

Route::get('profile/{username}',
    ['uses' => 'UserController@getProfile']);

Route::get('settings',
    ['middleware' => 'auth', 'uses' => 'UserController@getSettings']);
Route::post('settings/save-profile-image',
    ['middleware' => 'auth', 'uses' => 'UserController@postProfileImage']);
Route::post('settings/save-password-change',
    ['middleware' => 'auth', 'uses' => 'UserController@postPasswordChange']);
Route::post('settings/save-email-change',
    ['middleware' => 'auth', 'uses' => 'UserController@postEmailChange']);

Route::get('/add-game',
    ['middleware' => 'auth', 'uses' => 'GameController@getAddGame']);
Route::post('/add-game',
    ['middleware' => 'auth',  'uses' => 'GameController@postAddGame']);

Route::get('/add-version/{game_slug}',
    ['middleware' => ['auth', 'owngame'], 'uses' => 'GameController@getAddVersion']);
Route::post('/add-version/{game_slug}',
    ['middleware' => ['auth', 'owngame'], 'uses' => 'GameController@postAddVersion']);

Route::get('/edit-game/{game_slug}/{version_slug}',
    ['middleware' => ['auth', 'owngame'], 'uses' => 'GameController@getEditGame']);
Route::post('/edit-game/{game_slug}/{version_slug}',
    ['middleware' => ['auth', 'owngame'], 'uses' => 'GameController@postEditGame']);

Route::get('/add-downloads/{game_slug}',
    ['middleware' => ['auth', 'owngame'], 'uses' => 'DownloadController@getAddDownloads']);
Route::post('/add-downloads/{game_slug}',
    ['middleware' => ['auth', 'owngame'], 'uses' => 'DownloadController@postAddDownloads']);
Route::post('/save-file/{game_slug}/{platform_name}',
    ['middleware' => ['auth', 'owngame'], 'uses' => 'DownloadController@postUploadGameFile']);

Route::get('/promote/{game_slug}',
    ['middleware' => ['auth', 'owngame'], 'uses' => 'GameController@getPromoteGame']);

Route::get('/game/{game_slug}/{version_slug?}',
    ['uses' => 'GameController@getGame']);
Route::get('/download/{game_slug}/{platform_name}/{file_name}',
    ['uses' => 'DownloadController@getDownload']);

Route::post('/like/{game_slug}',
    ['middleware' => 'auth', 'uses' => 'LikeController@addLike']);

Route::get('/add-comment/{game_slug}',
    ['middleware' => 'auth', 'uses' => 'CommentController@getAddComment']); //so users not logged in get redirected
Route::get('/add-comment-reply/{comment_id}',
    ['middleware' => 'auth', 'uses' => 'CommentController@getAddCommentReply']); //so users not logged in get redirected
Route::post('/add-comment/{game_slug}',
    ['middleware' => 'auth', 'uses' => 'CommentController@postAddComment']);
Route::post('/add-comment-reply/{comment_id}',
    ['middleware' => 'auth', 'uses' => 'CommentController@postAddCommentReply']);

Route::get('/forum-add-comment/{discussion_slug}',
    ['middleware' => 'auth', 'uses' => 'ForumController@getAddComment']); //so users not logged in get redirected
Route::get('/forum-add-comment-reply/{comment_id}',
    ['middleware' => 'auth', 'uses' => 'ForumController@getAddCommentReply']); //so users not logged in get redirected
Route::post('/forum-add-comment/{discussion_slug}',
    ['middleware' => 'auth', 'uses' => 'ForumController@postAddComment']);
Route::post('/forum-add-comment-reply/{comment_id}',
    ['middleware' => 'auth', 'uses' => 'ForumController@postAddCommentReply']);

Route::get('/forum',
    ['uses' => 'ForumController@getDiscussions']);
Route::get('/add-discussion',
    ['middleware' => 'auth', 'uses' => 'ForumController@getAddDiscussion']);
Route::post('/add-discussion',
    ['middleware' => 'auth', 'uses' => 'ForumController@postAddDiscussion']);
Route::get('/forum/{discussion_slug}',
    ['uses' => 'ForumController@getDiscussion']);

Route::bind('platform_name', function($value, $route) {
    if(!in_array($value, \App\Game::$platforms)) {
        abort(400);
    }
    return $value;
});

Route::bind('discussion_slug', function($value, $route) {
    $discussion = App\Discussion::whereSlug($value)->first();
    if($discussion) return $discussion; //if discussion is found
    App::abort(404); //discussion not found
});

Route::get('/leaderboards',
    ['uses' => 'HomeController@getLeaderboard']);

Route::bind('game_slug', function($value, $route) {
    $game = App\Game::whereSlug($value)->first();
    if($game) return $game; //if game is found
    App::abort(404); //game not found
});

Route::bind('username', function($value, $route) {
    $user = App\User::where('username', $value)->first();
    if($user) return $user; //if user is found
    App::abort(404); //user not found
});

Route::bind('comment_id', function($value, $route) {
    return Comment::findOrFail($value);
});

Route::get('/contact-us',
    ['uses' => 'HomeController@getContactUs']);
Route::post('/contact-us',
    ['uses' => 'HomeController@postContactUs']);

Route::get('/screenshot-saturday',
    ['middleware' => 'auth.admin', 'uses' => 'ScheduledEmailController@getScreenshotSaturdayEmails']);

Route::get('/screenshot-saturday-send',
    ['middleware' => 'auth.admin', 'uses' => 'ScheduledEmailController@postScreenshotSaturdayEmails']);

Route::get('/about', 'HomeController@about');
Route::get('/privacy-policy', 'HomeController@privacyPolicy');
Route::get('/terms-conditions', 'HomeController@termsAndConditions');

Route::get('/weather',
    ['uses' => 'WeatherController@getWeather']);

