<?php

namespace App\Http\Controllers;

use App\Game;
use App\Http\Requests;
use App\Version;
use Illuminate\Http\Request;
use Input;
use Log;
use Mail;
use Redirect;
use Slynova\Commentable\Models\Comment;

class HomeController extends Controller
{
    public function getHome() {
        $gameIds = Version::orderBy('created_at', 'desc')->groupBy('game_id')->select('game_id')->take(7)->get();
        $games = Game::whereIn('id', $gameIds)->get();
        return view('home', compact('games'));
    }

    public function getGames(Request $request) {
        $pageTitle = 'Most Recently Updated';
        $games = Game::orderBy('created_at', 'desc')->take(16)->get();
        return view('games', compact('games', 'pageTitle'));
    }

    public function getGamesByGenre($genre, Request $request) {
        $pageTitle = Game::$genres[$genre];
        $games = Game::where('genre', $genre)->orderBy('created_at', 'desc')->take(16)->get();
        return view('games', compact('games', 'pageTitle'));
    }

    public function getNonRoasterGames(Request $request) {
        $gamesWithComments = Comment::groupBy('commentable_id')->lists('commentable_id');
        $games = Game::whereNotIn('id', $gamesWithComments)->orderBy('created_at', 'desc')->take(16)->get();
        $pageTitle = 'Not Yet Roasted';
        return view('games', compact('games', 'pageTitle'));
    }

    /**
     * User has started to create a new game from the home page, redirect with info to add game page
     */
    public function postHome(Request $request) {
        return redirect('/add-game')->withInput(['title' => $request->get('title'), 'email' => $request->get('email')]);
    }

    public function about() {
        return view('boilerplate.about');
    }

    public function privacyPolicy() {
        return view('boilerplate.privacy-policy');
    }

    public function termsAndConditions() {
        return view('boilerplate.termsAndConditions');
    }

    public function getContactUs() {
        return view('contactUs');
    }

    public function postContactUs(Request $request) {

        $this->validate($request, [
            'email' => 'required|max:254|email',
            'message' => 'required|max:2500'
        ]);

        Mail::send('emails.contactus', ['email' => Input::get('email'), 'content' => Input::get('message')], function($message) {
            $message->to('support@roastmygame.com')
                ->subject('Contact Us');
        });
        Log::info('Contact Us: '. Input::get('email') . ' : ' . Input::get('message'));
        return Redirect::route('/contact-us')->with('message', 'You\'re all set! We\'ll get back to you as soon as we can.');
    }
}
