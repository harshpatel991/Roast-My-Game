<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Game;
use App\User;
use App\Http\Requests;
use App\Version;
use Illuminate\Http\Request;
use Input;
use Log;
use DB;
use Mail;
use Redirect;
use harshpatel991\Commentable\Models\Comment;

class HomeController extends Controller
{
    public function getHome() {
        $popularGames = Game::orderBy('views', 'desc')
            ->where('created_at', '>=', Carbon::now()->subMonth())
            ->with(['versions' => function($query) {
                $query->orderBy('created_at', 'desc');
            }])
            ->take(12)
            ->get();

        $versions = Version::orderBy('created_at', 'desc')
            ->select('game_id')
            ->take(16)
            ->with(['game.versions' => function($query) {
                    $query->orderBy('created_at', 'desc');
            }])
            ->get();

        $games = collect();
        foreach($versions as $version) {
            $games->push($version->game);
        }
        $games = $games->unique()->values();

        return view('home', compact('games', 'popularGames'));
    }

    public function getGames(Request $request) {
        $pageTitle = '';
        $oldQuery = '';
        $oldGenre = '';
        $oldPlatform = '';
        $oldOrder = '';

        if($request->has('order')) {
            $oldOrder = $request->get('order');
            $gamesQuery = Game::orderBy($oldOrder, 'desc');
        } else { //default ordering
            $gamesQuery = Game::orderBy('created_at', 'desc');
        }

        if($request->has('query')) {
            $gamesQuery->where('title', 'LIKE', '%'.$request->get('query').'%');
            $oldQuery = $request->get('query');
        } if($request->has('genre')) {
            $genre = $request->get('genre');
            if(!array_key_exists($genre, Game::$genres)) {
                \App::abort(404); //genre not found
            }
            $gamesQuery->where('genre', '=', $genre);
            $oldGenre = $genre;
        } if($request->has('platform')) {
            $platform = $request->get('platform');
            if(!array_key_exists($platform, Game::$platformDropDown)) {
                \App::abort(404); //platform not found
            }
            $gameIds = Version::whereNotNull('link_'.$platform)->orderBy('created_at', 'desc')->select('game_id')->get();
            $gamesQuery->whereIn('id', $gameIds);
            $oldPlatform = $platform;
        } if($request->has('roasted')) {
            $gamesWithComments = Comment::where('my_commentable_type', 'Game')->groupBy('commentable_id')->lists('commentable_id');
            $gamesQuery->whereNotIn('id', $gamesWithComments);
        }
        $games = $gamesQuery->paginate(16);

        return view('games', compact('games', 'pageTitle', 'oldQuery', 'oldGenre', 'oldPlatform', 'oldOrder'));
    }

    public function getLeaderboard(Request $request) {
        //TODO: can probably eager load the mostRoastedGames
        $mostRoastedGameIds = Comment::select('commentable_id', DB::raw('count(*) as roast_count'))
                                ->groupBy('commentable_id')
                                ->orderBy('roast_count', 'desc')
                                ->limit(10)
                                ->get();
        $gameIds = array();
        foreach($mostRoastedGameIds as $mostRoastedGameId) {
            array_push($gameIds, $mostRoastedGameId['commentable_id']);
        }
        $gameIdsString = implode(",", $gameIds);
        $mostRoastedGames = Game::whereIn('id', $gameIds)
                                ->orderByRaw(DB::raw("FIELD(id, $gameIdsString)"))
                                ->get();

        $mostRoastingUsers = User::orderBy('points', 'desc')->take(10)->get();

        return view('leaderboard', compact('mostRoastedGames', 'mostRoastingUsers'));
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
        return redirect('/contact-us')->with('message', 'You\'re all set! We\'ll get back to you as soon as we can.');
    }
}
