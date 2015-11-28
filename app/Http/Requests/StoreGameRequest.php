<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class StoreGameRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $linkRules = 'max:255|url';
        return [
            'title' => 'required|max:255',
            'developer' => 'required|max:255',
            'thumbnail' => 'required|image',
            'genre' => 'required|max: 255|in:'. implode(',', array_keys(\App\Game::$genres)),
            'description' => 'max: 1000',
            'platforms' => 'required|max: 140',
            'link-website' => $linkRules,
            'link-twitter' => $linkRules,
            'link-youtube' => $linkRules,
            'link-google-plus' => $linkRules,
            'link-twitch' => $linkRules,
            'link-facebook' => $linkRules,
            'link-google-play' => $linkRules,
            'link-app-store' => $linkRules,
            'link-windows-store' => $linkRules,
            'link-steam' => $linkRules,
            'version' => 'required|max:255',
            'beta' => 'boolean',
            'video_link' => 'max:255|url',
            'image1' => 'required|image',
            'image2' => 'image',
            'image3' => 'image',
            'image4' => 'image',
            'upcoming_features' => 'max:1000',
            'email' => 'email|min:1',
            'password' => 'min:6|max:60',
        ];
    }
}
