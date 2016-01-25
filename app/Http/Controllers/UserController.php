<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use DB;
use Redirect;
use Auth;
use Utils;
use Validator;
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

        $isTheLoggedInUser = false;
        if(Auth::check() && Auth::user()->id == $user->id) {
            $isTheLoggedInUser = true;
        }

        return view('profile', compact('user', 'games', 'comments', 'likes', 'isTheLoggedInUser'));
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

    public function getSettings() {
        $user = Auth::user();
        return view('settings', compact('user'));
    }

    public function postPasswordChange(Request $request) {
        $user = Auth::user();

        $currentPassword = $request->get('current-password');
        $newPassword = $request->get('password');

        if( !Hash::check($currentPassword, $user->password) ) {
            return redirect()->back()->withErrors('Current password is invalid');
        }

        $this->validate($request, [
            'password' => 'required|confirmed|min:6',
        ]);

        $user->password = bcrypt($newPassword);
        $user->save();
        Auth::login($user);

        return redirect()->back()->with(['message' =>'Password changed!']);
    }

    public function postProfileImage(Request $request) {
        $user = Auth::user();

        $this->validate($request, [
            'profile_image' => 'required|image|max:2000'
        ]);

        $user->profile_image = Utils::upload_image_profile($request->file('profile_image'), $user->username, 'profile-images');
        $user->save();
        return redirect()->back()->with(['message' =>'Profile image changed!']);
    }

    public function postEmailChange (Request $request) {
        $user = Auth::user();
        $user->mail_roasts = $request->get('mail_roasts', false) == "true" ? true : false;
        $user->mail_comments = $request->get('mail_comments', false) == "true" ? true : false;
        $user->mail_progress_reminders = $request->get('mail_progress_reminders', false) == "true" ? true : false;
        $user->mail_site_updates = $request->get('mail_site_updates', false) == "true" ? true : false;
        $user->save();

        return redirect()->back()->with(['message' =>'Email preferences saved!']);
    }
}
