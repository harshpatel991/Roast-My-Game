<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Redirect;
use Auth;
use App\User;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Slynova\Commentable\Models\Comment;

class UserController extends Controller
{

    public function getProfile($user, Request $request) {
        $games = $user->games()->with(['versions' => function ($query) {
            $query->orderBy('created_at', 'desc');
        }])->get();

        $comments = Comment::where('user_id', $user->id)->get();
        $likes = $user->likes()->with('game')->get();

        $versionsCount = 0;
        foreach($games as $game){
            $versionsCount += $game->versions->count();
        }

        $isTheLoggedInUser = false;
        if(Auth::check() && Auth::user()->id == $user->id) {
            $isTheLoggedInUser = true;
        }

        return view('profile', compact('user', 'games', 'comments', 'versionsCount', 'likes', 'isTheLoggedInUser'));
    }

    public function registerSuccess() {

        $email = 'your email';
        if(\Auth::check()) {
            $email = \Auth::user()->email;
        }

        return view('auth.registerSuccess', compact('email'));
    }

    public function verifySuccess($confirmation_code)
    {
        if(!$confirmation_code)
        {
            return Redirect::route('home');
        }

        $user = User::whereConfirmationCode($confirmation_code)->first();

        if (!$user)
        {
            return redirect('/')->withErrors(['confirmation' =>'Confirmation code not found']);
        }

        if($user->status = 'unconfirmed')
        {
            $user->points = $user->points + User::$CONFIRM_EMAIL_POINTS;
            $user->status = 'good';
        }
        $user->save();

        return redirect('/')->with(['message' =>'Your email has been verified!']);
    }



}
