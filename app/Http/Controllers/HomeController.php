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
use Slynova\Commentable\Models\Comment;

class HomeController extends Controller
{
    public static $RECENTLY_UPDATED = "recently_updated";
    public static $NOT_YET_ROASTED = "not_yet_roasted";
    public static $GENRE = "genre";
    public static $PLATFORM = "platform";

    public function getHome() {
        $popularGames = Game::orderBy('views', 'desc')
            ->where('created_at', '>=', Carbon::now()->subMonth())
            ->with(['versions' => function($query) {
                $query->orderBy('created_at', 'desc');
            }])
            ->take(8)
            ->get();

        $versions = Version::orderBy('created_at', 'desc')
            ->select('game_id')
            ->take(12)
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
        $pageTitle = 'Most Recently Updated';
        $games = Game::orderBy('created_at', 'desc')
            ->get();

        $selectedButton = $this::$RECENTLY_UPDATED;
        return view('games', compact('games', 'pageTitle', 'selectedButton'));
    }

    public function getGamesByGenre($genre, Request $request) {
        $pageTitle = Game::$genres[$genre];
        $games = Game::where('genre', $genre)
            ->orderBy('created_at', 'desc')
            ->take(16)
            ->get();
        $selectedButton = $this::$GENRE;
        return view('games', compact('games', 'pageTitle', 'genre', 'selectedButton'));
    }

    public function getNonRoasterGames(Request $request) {
        $gamesWithComments = Comment::groupBy('commentable_id')->lists('commentable_id');
        $games = Game::whereNotIn('id', $gamesWithComments)
            ->orderBy('created_at', 'desc')
            ->take(16)
            ->get();
        $pageTitle = 'Not Yet Roasted';
        $selectedButton = $this::$NOT_YET_ROASTED;
        return view('games', compact('games', 'pageTitle', 'selectedButton'));
    }

    public function getGamesByPlatform($platform, Request $request) {
        $pageTitle = \App\Game::$platformDropDown[$platform];

        $versions = Version::whereNotNull('link_'.$platform)->orderBy('created_at', 'desc')->take(16)->with('game')->get();
        $games = array();
        foreach ($versions as $version) {
            if(!in_array($version->game, $games, true)) {
                array_push($games, $version->game);
            }
        }

        $selectedButton = $this::$PLATFORM;
        return view('games', compact('games', 'pageTitle', 'platform', 'selectedButton'));
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
        return Redirect::route('/contact-us')->with('message', 'You\'re all set! We\'ll get back to you as soon as we can.');
    }

    public static function buttonSelected($currentSelectedButton, $requiredButton) {
        if ($currentSelectedButton == $requiredButton) {
            return 'btn-primary';
        }
        return 'btn-light-blue';
    }
}
