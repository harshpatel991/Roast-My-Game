<?php

namespace App\Http\Controllers;

use App\User;
use App\Game;
use App\Http\Requests\StoreGameRequest;
use App\Http\Requests\StoreVersionRequest;
use App\Http\Requests\StoreEditGameRequest;
use App\Http\Utils;
use App\Like;
use App\Version;
use Auth;
use DB;
use Illuminate\Html\FormBuilder;
use Illuminate\Http\Request;
use Log;
use Slynova\Commentable\Models\Comment;

class GameController extends Controller
{
    public function getGame(Game $game, Request $request, $selectedVersionSlug='latest') {
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

        $platformLinks = array_filter(Utils::preg_grep_keys("/link_platform_.+/", $currentVersion->getAttributes()));

        $platform_Icon_Name_Link = Game::translatePlatformLinkTo_Icon_Name_Link($platformLinks);

        $socialLinks = Utils::preg_grep_keys("/link_social_.+/", $game->getAttributes());
        $linkIcons = Game::translateLinkToGlyph($socialLinks);
        $linkTexts = Game::translateLinkText($socialLinks);

        $isLiked = false;
        if (Auth::check()) {
            $likes = Like::where('user_id', Auth::user()->id)->where('game_id', $game->id)->count();
            if( $likes >= 1) {
                $isLiked = true;
            }
        }

        $comments = $game->comments()->get();

        return view('game-alt', compact('game', 'versions', 'currentVersion', 'images', 'platform_Icon_Name_Link', 'socialLinks', 'linkIcons', 'linkTexts', 'isLiked', 'video_thumbnail', 'comments'));
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

    public function postAddGame(StoreGameRequest $request) {
        Log::info('Request to store a game: ' . print_R($request->all(), TRUE));
        $game = new Game;
        $version = new Version;

        $game->setGameFromRequest($game, $request);
        $game->slug = Utils::generate_unique_slug($game->title);

        $version->slug = Utils::generate_unique_version_slug($request->version);
        $version->setVersionFromRequest($version, $game, $request);

        $game->save();
        $version->game_id = $game->id;
        $version->save();

        //save the user points
        $request->user()->addPointsAndSave(User::$ADD_GAME_POINTS);

        return redirect('game/'.$game->slug)->with('message', 'Your game has been added! Please consider leaving feedback for other games.');
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

    public function getEditGame(Game $game, $version, Request $request) {
        $isEdit = true;
        $this->addCustomFormBuilders();

        $version = $game->versions()->where('slug', $version)->first();
        return view('editGame', compact('game', 'version', 'isEdit'));
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

    private function addCustomFormBuilders() {
        FormBuilder::macro('myInput', function($id, $name, $placeholder='', $primaryValue='', $secondaryValue='')
        {
            $value = $primaryValue!='' ? $primaryValue : $secondaryValue;
            return
            '<div class="form-group">'.
                FormBuilder::label($id, $name, ['class' => 'col-sm-2 control-label form-label'])
                .'<div class="col-sm-6">'.
                    FormBuilder::text($id, $value, ['class' => 'form-control', 'placeholder' => $placeholder])
                .'</div>'
            .'</div>';
        });

        FormBuilder::macro('myCheckbox', function($id, $name, $checkBoxValue)
        {
            return FormBuilder::checkbox($id, $checkBoxValue, old($id, false), ['id' => $checkBoxValue])
            .FormBuilder::label('', $name, ['class' => 'control-label']);
        });

        FormBuilder::macro('myImageWithThumbnail', function($id)
        {
            return '<div class="col-sm-3">'.
            '<div class="embed-responsive embed-responsive-16by9">'.
            '<img class="embed-responsive-item" id="' . $id . '-preview" src="/images/placeholder.jpg"/>'.
            '</div>'.
            FormBuilder::file($id, ['class' => 'form-control', 'accept' => 'image/*', 'id' => $id]).
            '</div>';
        });
    }
}
