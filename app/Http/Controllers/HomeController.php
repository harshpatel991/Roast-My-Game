<?php

namespace App\Http\Controllers;

use App\Game;
use App\Version;
use App\Http\Requests;
use Illuminate\Http\Request;
use Input;
use Redirect;
use Mail;
use Log;

class HomeController extends Controller
{
    public function getHome() {
        $gameIds = Version::orderBy('created_at', 'desc')->groupBy('game_id')->select('game_id')->take(3)->get();
        $games = Game::whereIn('id', $gameIds)->get();
        return view('home', compact('games'));
    }

    /**
     * User has started to create a new game from the home page, redirect with info to add game page
     */
    public function postHome(Request $request) {
        return redirect('/add-game')->withInput(['title' => $request->get('title'), 'email' => $request->get('email')]);
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
