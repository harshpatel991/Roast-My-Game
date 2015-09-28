<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Game;

class GameController extends Controller
{
    public function getGame(Game $game) {
        return view('game', compact('game'));
    }

    public function getAddGame() {
        return view('addGame');
    }

    public function postAddGame(Request $request) {
        dd($request->input());

    }
}
