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

        $images = array_filter(array($currentVersion->image1, $currentVersion->image2, $currentVersion->image3, $currentVersion->image4));
        $platforms = explode (',', $game->platforms);

        array_walk($platforms, "App\Game::translatePlatformToGlyph");
        $links = Utils::preg_grep_keys("/link-.+/", $game->getAttributes());
        $links = Game::translateLinkToGlyph($links);

        //TODO: check if this user already liked this game
        $isLiked = false;

        return view('game', compact('game', 'versions', 'currentVersion', 'images', 'platforms', 'links', 'isLiked'));
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

    }

    public function addFavorite(Game $game) {
        //TODO: check that this user has not already liked this game
        $game->likes = $game->likes + 1;
        $game->save();

        //TODO: add record to likes table

        return $game->likes;
    }


}
