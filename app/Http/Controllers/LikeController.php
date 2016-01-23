<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Like;
use App\Game;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class LikeController extends Controller
{
    public function addLike(Game $game, Request $request) {
        $user = $request->user();

        $likeCount = Like::where('user_id', $user->id)->where('game_id', $game->id)->count();
        if($likeCount >= 1) {
            return response('Precondition Failed', 412);
        }

        $game->likes = $game->likes + 1;

        $like = new Like;
        $like->game_id = $game->id;
        $like->user_id = $user->id;

        $game->save();
        $like->save();
        //save the user points
        $user->addPointsAndSave(User::$LIKE_POINTS);

        return $game->likes;
    }
}
