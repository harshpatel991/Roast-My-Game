<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Slynova\Commentable\Models\Comment;

class UserController extends Controller
{

    public function getProfile(Request $request) {

        $user = $request->user();
        $games = $user->games()->get();
        $comments = Comment::where('user_id', $user->id)->get();

        if(count($games) > 0) {
            $latestImage = $games[0]->versions()->orderBy('version', 'desc')->limit(1)->first()->image1;
        }


        return view('profile', compact('user', 'games', 'latestImage', 'comments'));
    }

}
