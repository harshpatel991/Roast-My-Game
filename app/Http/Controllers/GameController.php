<?php

namespace App\Http\Controllers;

use App\Mail\AddGameSuccess;
use App\User;
use App\Game;
use Mail;
use App\Http\Requests\StoreGameRequest;
use App\Http\Requests\StoreVersionRequest;
use App\Http\Requests\StoreEditGameRequest;
use App\Http\Utils;
use App\Http\CustomForm;
use App\Like;
use App\Version;
use Auth;
use DB;
use Illuminate\Http\Request;
use Log;
use harshpatel991\Commentable\Models\Comment;

class GameController extends Controller
{
    use CustomForm;

    public function getGame(Game $game, Request $request, $selectedVersionSlug='latest') {
        $isFirstTimeUser = $request->session()->has('first-time-user') ? false : true;
        $request->session()->put('first-time-user', true);

        if(!$request->session()->has($game->slug)) //Count a view
        {
            $request->session()->put($game->slug, true);
            $game->views = $game->views+1;
            $game->save();
        }

        $versions = $game->versions()->orderBy('created_at', 'desc')->get();

        if(count($versions) <= 0) {
            abort(404);
        }

        if($selectedVersionSlug != 'latest') {
            $versions = $versions->keyBy('slug');
            $currentVersion = $versions->get($selectedVersionSlug);

            if($currentVersion == null) {
                abort(404);
            }
        } else {
            $currentVersion = $versions->get(0);
        }

        $video_thumbnail = '';
        if(preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $currentVersion->video_link, $matches)) {
            $video_thumbnail = $matches[1];
        }

        $images = array_filter(array($currentVersion->image1, $currentVersion->image2, $currentVersion->image3, $currentVersion->image4));

        $platformLinks = array_filter(Utils::preg_grep_keys("/link_platform_.+/", $game->getAttributes()));

        $platform_Icon_Name_Link = Game::translatePlatformLinkTo_Icon_Name_Link($platformLinks);

        $socialLinks = Utils::preg_grep_keys("/link_social_.+/", $game->getAttributes());
        $linkIcons = Game::translateLinkToGlyph($socialLinks);
        $linkTexts = Game::translateLinkText($socialLinks);

        $isLiked = false;
        if (Auth::check()) {
            $likes = Like::where('user_id', Auth::user()->id)->where('game_id', $game->id)->take(1)->count();
            if( $likes >= 1) {
                $isLiked = true;
            }
        }

        $comments = $game->comments()->orderBy('created_at', 'asc')->get();
        $relatedGames = Game::where('genre', $game->genre)
            ->where('slug', '<>', $game->slug)
            ->with(['versions' => function($query) {
                $query->orderBy('created_at', 'desc');
            }])
            ->take(4)
            ->get();

        return view('game-alt', compact('isFirstTimeUser', 'game', 'versions', 'currentVersion', 'images', 'platform_Icon_Name_Link', 'socialLinks', 'linkIcons', 'linkTexts', 'isLiked', 'video_thumbnail', 'comments', 'relatedGames'));
    }

    public function getAddGame() {
        // check if user has minimum comments to add a game
        $user = Auth::user();
        $commentCount = Comment::where('user_id', $user->id)->count();

        if($commentCount < 1) {
            return redirect('/profile/'.$user->username)->with('warning', 'To give a chance for all games to get feedback, you must roast one game before adding your own game.');
        }
        $game = new Game;
        $version = new Version;
        $this->addCustomFormBuilders();
        return view('addGame', compact('game', 'version'));
    }

    public function getAddVersion(Game $game) {
        $this->addCustomFormBuilders();
        $version = new Version;
        return view('addVersion', compact('game', 'version'));
    }

    public function getEditGame(Game $game, $version, Request $request) {
        $isEdit = true;
        $this->addCustomFormBuilders();

        $version = $game->versions()->where('slug', $version)->first();
        return view('editGame', compact('game', 'version', 'isEdit'));
    }

    public function postAddGame(StoreGameRequest $request) {
        Log::info('Request to store a game: ' . print_R($request->all(), TRUE));
        $game = new Game;
        $version = new Version;

        $game->slug = Utils::generate_unique_slug($request->get('title'));
        $game->setGameFromRequest($game, $request);

        $version->slug = Utils::generate_unique_version_slug($request->version);
        $version->setVersionFromRequest($version, $game, $request);

        $game->save();
        $version->game_id = $game->id;
        $version->save();

        //save the user points
        $request->user()->addPointsAndSave(User::$ADD_GAME_POINTS);

        //send email
        $sendTo = $request->user()->email;
        \Illuminate\Support\Facades\Mail::to($sendTo)
            ->bcc('roastmygame@gmail.com')
            ->queue(new AddGameSuccess($game, 'https://roastmygame.com/images/logo-dark.png'));
        Log::info('Add game success sent to: '.$sendTo);
        
        return redirect('game/'.$game->slug)->with('warning', 'Your game has been added! Visit your profile to add versions and downloads.');
    }

    public function postAddVersion(Game $game, StoreVersionRequest $request) {
        Log::info('Request to store a version: ' . print_R($request->all(), TRUE));
        $version = new Version;
        $version->slug = Utils::generate_unique_version_slug($request->version, $game->id);
        $version->setVersionFromRequest($version, $game, $request);
        $version->game_id = $game->id;
        $version->save();

        //save the user points
        $request->user()->addPointsAndSave(User::$ADD_VERSION_POINTS);

        return redirect('game/'.$game->slug)->with('message', 'Your progress has been added! Please consider leaving feedback for other games.');
    }

    //slugs stay the same when editing games
    public function postEditGame(Game $game, $version, StoreEditGameRequest $request) {
        Log::info('Request to store an edit game: ' . print_R($request->all(), TRUE));
        $version = $game->versions()->where('slug', $version)->first();

        $game->setGameFromRequest($game, $request);
        $version->setVersionFromRequest($version, $game, $request);

        $game->save();
        $version->save();

        return redirect('game/'.$game->slug)->with('message', 'Game updated!');
    }

    public function getPromoteGame(Game $game, Request $request) {
        return view('promote', compact('game'));
    }
}
