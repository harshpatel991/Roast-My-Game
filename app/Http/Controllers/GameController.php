<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

use App\Http\Utils;
use Illuminate\Html\FormBuilder;

use App\Game;
use App\Version;

class GameController extends Controller
{
    public function getGame(Game $game, Request $request, $selectedVersionSlug='latest') {

        if(!$request->session()->has('v_'.$game->slug)) //Count a view
        {
            $request->session()->put('v_'.$game->slug, true);
            $game->views = $game->views+1;
            $game->save();
        }

        $versions = $game->versions()->orderBy('version', 'desc')->get();

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
        $platforms = explode (',', $game->platforms);

        array_walk($platforms, "App\Game::translatePlatformToGlyph");
        $links = Utils::preg_grep_keys("/link_social_.+/", $game->getAttributes());
        $links = Game::translateLinkToGlyph($links);

        //TODO: check if this user already liked this game
        $isLiked = false;


        return view('game-alt', compact('game', 'versions', 'currentVersion', 'images', 'platforms', 'links', 'isLiked', 'video_thumbnail'));
    }

    public function getAddGame() {
        $this->addCustomFormBuilders();
        return view('addGame');
    }

    public function getAddVersion(Game $game) {
        $this->addCustomFormBuilders();
        return view('addVersion', compact('game'));
    }

    public function postAddGame(Request $request) {
        $game = new Game;
        $game->title = $request->get('title');
        $game->user_id = $request->user()->id;
        $game->slug = Utils::generate_unique_slug($game->title);
        $game->genre = $request->genre;
        $game->description = $request->description;
        $game->platforms = implode(",", $request->platforms);
        $game->link_platform_pc = $request->link_platform_pc;
        $game->link_platform_mac = $request->link_platform_mac;
        $game->link_platform_ios = $request->link_platform_ios;
        $game->link_platform_android = $request->link_platform_android;
        $game->link_platform_unity_web = $request->link_platform_unity_web;
        $game->link_platform_windows_phone = $request->link_platform_windows_phone;
        $game->link_social_website = $request->link_social_website;
        $game->link_social_twitter = $request->link_social_twitter;
        $game->link_social_youtube = $request->link_social_youtube;
        $game->link_social_google_plus = $request->link_social_google_plus;
        $game->link_social_facebook = $request->link_social_facebook;

        $version = $this->createVersion($game, $request);

        $game->save();

        $version->game_id = $game->id;
        $version->save();

        return redirect('game/'.$game->slug);
    }

    public function postAddVersion(Game $game, Request $request) {
        $version = $this->createVersion($game, $request);
        $version->save();
        return redirect('game/'.$game->slug);
    }

    private function createVersion($game, Request $request) {
        $version = new Version;
        $version->game_id = $game->id;
        $version->version = $request->version;
        $version->slug = Utils::generate_unique_slug($request->version);
        $version->beta = $request->get('beta', false) == "true" ? true : false;
        $version->video_link = $request->video_link;

        if($request->hasFile('image1')) {
            $version->image1 = Utils::upload_image($request->file('image1'), $game->slug . '-' . $version->slug . '-1');
        } if($request->hasFile('image2')) {
            $version->image2 = Utils::upload_image($request->file('image2'), $game->slug . '-' . $version->slug . '-2');
        } if($request->hasFile('image3')) {
            $version->image3 = Utils::upload_image($request->file('image3'), $game->slug . '-' . $version->slug . '-3');
        } if($request->hasFile('image4')) {
            $version->image4 = Utils::upload_image($request->file('image4'), $game->slug . '-' . $version->slug . '-4');
        }

        $version->upcoming_features = $request->upcoming_features;
        $version->changes = $request->changes;
        return $version;
    }

    public function addFavorite(Game $game) {
        //TODO: check that this user has not already liked this game
        $game->likes = $game->likes + 1;
        $game->save();

        //TODO: add record to likes table

        return $game->likes;
    }

    private function addCustomFormBuilders() {
        FormBuilder::macro('myInput', function($id, $name, $placeholder='')
        {
            return '<div class="form-group">'.
            FormBuilder::label($id, $name, ['class' => 'col-sm-2 control-label form-label'])
            .'<div class="col-sm-6">'.
            FormBuilder::text($id, old($id), ['class' => 'form-control', 'placeholder' => $placeholder])
            .'</div>'
            .'</div>';
        });

        FormBuilder::macro('myCheckbox', function($id, $name, $checkBoxValue)
        {
            return FormBuilder::checkbox($id, $checkBoxValue, old($id, false))
            .FormBuilder::label('', $name, ['class' => 'control-label form-label']);
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
    }


}
