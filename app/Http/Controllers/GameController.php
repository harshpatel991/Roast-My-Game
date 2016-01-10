<?php

namespace App\Http\Controllers;

use App\Game;
use App\Http\Requests\StoreGameRequest;
use App\Http\Requests\StoreVersionRequest;
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

        $nextGame = $this->getNextGame(array_keys($request->session()->all()))->slug; //the link to view the next game

        return view('game-alt', compact('game', 'versions', 'currentVersion', 'images', 'platform_Icon_Name_Link', 'socialLinks', 'linkIcons', 'linkTexts', 'isLiked', 'video_thumbnail', 'nextGame', 'comments'));
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
        $game->title = $request->get('title');
        $game->user_id = $request->user()->id;
        $game->slug = Utils::generate_unique_slug($game->title);
        $game->genre = $request->genre;
        $game->description = $request->description;

        $game->link_social_greenlight = $request->has('link_social_greenlight') ? $request->link_social_greenlight : null;
        $game->link_social_website = $request->has('link_social_website') ? $request->link_social_website : null;
        $game->link_social_twitter = $request->has('link_social_twitter') ? $request->link_social_twitter : null;
        $game->link_social_youtube = $request->has('link_social_youtube') ? $request->link_social_youtube : null;
        $game->link_social_google_plus = $request->has('link_social_google_plus') ? $request->link_social_google_plus : null;
        $game->link_social_facebook = $request->has('link_social_facebook') ? $request->link_social_facebook : null;

        $version = $this->createVersion($game, $request);

        $game->save();

        $version->game_id = $game->id;
        $version->save();

        return redirect('game/'.$game->slug)->with('message', 'Your game has been added! Please consider leaving feedback for other games.');
    }

    public function postAddVersion(Game $game, StoreVersionRequest $request) {
        Log::info('Request to store a version: ' . print_R($request->all(), TRUE));
        $version = $this->createVersion($game, $request);
        $version->save();
        return redirect('game/'.$game->slug)->with('message', 'Your progress has been added! Please consider leaving feedback for other games.');
    }

    private function createVersion($game, Request $request) {
        $version = new Version;
        $version->game_id = $game->id;
        $version->version = $request->version;
        $version->slug = Utils::generate_unique_slug($request->version);
        $version->beta = $request->get('beta', false) == "true" ? true : false;
        $version->video_link = $request->video_link;

        if($request->hasFile('image1')) {
            $version->image1 = Utils::upload_image($request->file('image1'), $game->slug . '-' . $version->slug . '-1', $game->slug);
        } if($request->hasFile('image2')) {
            $version->image2 = Utils::upload_image($request->file('image2'), $game->slug . '-' . $version->slug . '-2', $game->slug);
        } if($request->hasFile('image3')) {
            $version->image3 = Utils::upload_image($request->file('image3'), $game->slug . '-' . $version->slug . '-3', $game->slug);
        } if($request->hasFile('image4')) {
            $version->image4 = Utils::upload_image($request->file('image4'), $game->slug . '-' . $version->slug . '-4', $game->slug);
        }

        $version->link_platform_pc = $request->has('link_platform_pc') ? $request->link_platform_pc : null;
        $version->link_platform_mac = $request->has('link_platform_mac') ? $request->link_platform_mac : null;
        $version->link_platform_ios = $request->has('link_platform_ios') ? $request->link_platform_ios : null;
        $version->link_platform_android = $request->has('link_platform_android') ? $request->link_platform_android : null;
        $version->link_platform_unity = $request->has('link_platform_unity') ? $request->link_platform_unity : null;
        $version->link_platform_other = $request->has('link_platform_other') ? $request->link_platform_other : null;

        $version->upcoming_features = $request->upcoming_features;
        $version->changes = $request->changes;
        return $version;
    }

    public function getEditGame(Game $game, Request $request) {
        $isEdit = true;
        $this->addCustomFormBuilders();

        $version = $game->versions()->orderBy('created_at', 'desc')->first();
        return view('editGame', compact('game', 'version', 'isEdit'));
    }

    public function postEditGame(Game $game, Request $request) {
        return view('editGame');
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

    private function getNextGame($allViewedGames) {
        $searchRange = 60;
        $avgLikes = DB::table('games')->avg('likes');
        $game = Game::whereBetween('likes', [$avgLikes-$searchRange, $avgLikes+$searchRange])->orderBy('likes')
            ->whereNotIn('slug', $allViewedGames)->first();

        if($game == null) {
            return Game::orderByRaw("RAND()")->first();
        }
        return $game;

    }


}
