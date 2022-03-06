<?php

namespace App\Http\Requests;

use Auth;
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
        if (Auth::check())
        {
            return true;

        }

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
        return array_merge(
            ['title' => 'required|max:255',
            'genre' => 'required|max: 255|in:'. implode(',', array_keys(\App\Game::$genres)),
            'description' => 'max: 5000',
            'platforms' => 'max: 140',

            'link_social_greenlight' => $linkRules,
            'link_social_website' => $linkRules,
            'link_social_twitter' => $linkRules,
            'link_social_youtube' => $linkRules,
            'link_social_google_plus' => $linkRules,
            'link_social_facebook' => $linkRules
            ],
            StoreVersionRequest::$rulesList
        );
    }
}
