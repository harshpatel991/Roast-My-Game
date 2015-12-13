<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Game;

class HomeController extends Controller
{
    public function getHome() {
        $games = Game::all();
//        dd($games);
        return view('home', compact('games'));
    }

    /**
     * User has started to create a new game from the home page, redirect with info to add game page
     */
    public function postHome(Request $request) {
        return redirect('/add-game')->withInput(['title' => $request->get('title'), 'email' => $request->get('email')]);
    }
}
