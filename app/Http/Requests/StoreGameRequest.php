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

            'link_platform_pc' => $linkRules,
            'link_platform_mac' => $linkRules,
            'link_platform_ios' => $linkRules,
            'link_platform_android' => $linkRules,
            'link_platform_unity_web' => $linkRules,
            'link_platform_windows_phone' => $linkRules,

            'link_social_greenlight' => $linkRules,
            'link_social_website' => $linkRules,
            'link_social_twitter' => $linkRules,
            'link_social_youtube' => $linkRules,
            'link_social_google_plus' => $linkRules,
            'link_social_facebook' => $linkRules,

            'version' => 'required|max:255',
            'beta' => 'boolean',
            'video_link' => 'max:255|url',
            'image1' => 'required|image',
            'image2' => 'image',
            'image3' => 'image',
            'image4' => 'image',
            'upcoming_features' => 'max:1000',
            'changes' => 'max:1000',
            'email' => 'email|min:1',
            'password' => 'min:6|max:60',
        ];
    }
}
