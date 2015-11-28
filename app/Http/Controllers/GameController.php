<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Html\FormBuilder;
use App\Http\Requests;
use App\Http\Utils;

use App\Game;

class GameController extends Controller
{
    public function getGame(Game $game, $selectedVersion = 'latest') {

        $versions = $game->versions()->orderBy('version', 'desc')->get();

        if(count($versions) <= 0) {
            abort(404);
        }

        if($selectedVersion != 'latest') {
            $versions = $versions->keyBy('version');
            $currentVersion = $versions->get($selectedVersion);

            if($currentVersion == null) {
                abort(404);
            }
        } else {
            $currentVersion = $versions->get(0);
        }

        preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $currentVersion->video_link, $matches);
        $video_thumbnail = $matches[1];

        $images = array_filter(array($currentVersion->image1, $currentVersion->image2, $currentVersion->image3, $currentVersion->image4));
        $platforms = explode (',', $game->platforms);

        array_walk($platforms, "App\Game::translatePlatformToGlyph");
        $links = Utils::preg_grep_keys("/link_.+/", $game->getAttributes());
        $links = Game::translateLinkToGlyph($links);

        //TODO: check if this user already liked this game
        $isLiked = false;


        return view('game-alt', compact('game', 'versions', 'currentVersion', 'images', 'platforms', 'links', 'isLiked', 'video_thumbnail'));
    }

    public function getAddGame() {
        FormBuilder::macro('myInput', function($id, $name, $placeholder='')
        {
            return '<div class="form-group">'.
                        FormBuilder::label($id, $name, ['class' => 'col-sm-2 control-label form-label'])
                        .'<div class="col-sm-6">'.
                            FormBuilder::text($id, old($id), ['class' => 'form-control', 'placeholder' => $placeholder])
                        .'</div>'
                    .'</div>';
        });

        FormBuilder::macro('myCheckbox', function($id, $name)
        {
            return FormBuilder::checkbox($id, $id, old($id, false))
                    .FormBuilder::label($id, $name, ['class' => 'control-label form-label']);
        });

        FormBuilder::macro('myImageWithThumbnail', function($id)
        {
        return '<div class="col-sm-3">'.
                    '<div class="embed-responsive embed-responsive-16by9">'.
                        '<img class="embed-responsive-item" id="' . $id . '-preview"/>'.
                    '</div>'.
                    FormBuilder::file($id, ['class' => 'form-control', 'accept' => 'image/*', 'id' => $id]).
                '</div>';
        });

        return view('addGame');
    }

    public function postAddGame(Request $request) {
        dd($request->all());

        //TODO
        $game = new Game;
        $game->title = $request->get('title');
        $game->developer = $request->get('developer');

        //TODO: save the thumbnail image
        $thumbnailName = '';//$Helper::saveThumbnail($thumbnail);
        $game->thumbnail = $thumbnailName;
        $game->genre = $request->genre;
        $game->description = $request->description;
        $game->platforms = $request->platforms;
        $game->link_website = $request->link_website;
        $game->link_twitter = $request->link_twitter;
        $game->link_youtube = $request->link_youtube;
        $game->link_google_plus = $request->link_google_plus;
        $game->link_facebook = $request->link_facebook;
        $game->link_google_play = $request->link_google_play;
        $game->link_app_store = $request->link_app_store;
        $game->link_windows_store = $request->link_windows_store;
        $game->link_steam = $request->link_steam;

        $version = new Version;
        $version->version = $request->version;
        $version->beta = $request->beta;

        $version->video_link = $request->video_link;

        //TODO: save the thumbnail image
        $image1Name = '';//$Helper::saveThumbnail($thumbnail);
        $version->image1 = $image1Name;

        //TODO: save the thumbnail image
        $image2Name = '';//$Helper::saveThumbnail($thumbnail);
        $version->image2 = $image2Name;

        //TODO: save the thumbnail image
        $image3Name = '';//$Helper::saveThumbnail($thumbnail);
        $version->image3 = $image3Name;

        //TODO: save the thumbnail image
        $image4Name = '';//$Helper::saveThumbnail($thumbnail);
        $version->image4 = $image4Name;

        $version->upcoming_features = $request->upcoming_features;

        $game->save();
        $version->save();



    }

    public function addFavorite(Game $game) {
        //TODO: check that this user has not already liked this game
        $game->likes = $game->likes + 1;
        $game->save();

        //TODO: add record to likes table

        return $game->likes;
    }


}
