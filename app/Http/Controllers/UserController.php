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
        $likes = $user->likes()->get();
        $versionsCount = 0;

        foreach($games as $game){
            $versionsCount += $game->versions()->count();
        }


        return view('profile', compact('user', 'games', 'comments', 'versionsCount', 'likes'));
    }

}
