<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Redirect;
use App\User;
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

    //TODO: show users success page after signing up
//    public function signupSuccess() {
//
//        $recentPosts = Post::orderBy('created_at')->limit(5)->get();
//
//        $email = 'your email';
//        if(\Auth::check()) {
//            $email = \Auth::user()->email;
//        }
//
//        return view('signUpSuccess', compact('email', 'recentPosts', 'randomPost'));
//    }

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
            $user->status = 'good';
        }
        $user->save();

        return redirect('/')->with(['message' =>'Your email has been verified!']);
    }

}
