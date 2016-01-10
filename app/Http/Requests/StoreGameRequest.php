<?php

namespace App\Http\Requests;

use Auth;
use App\Http\Requests\Request;

class StoreGameRequest extends Request
{

    public static function storeRulesList() {
        return ['title' => 'required|max:255',
            'genre' => 'required|max: 255|in:'. implode(',', array_keys(\App\Game::$genres)),
            'description' => 'max: 5000',
            'platforms' => 'max: 140',

            'link_social_greenlight' => 'max:255|url',
            'link_social_website' => 'max:255|url',
            'link_social_twitter' => 'max:255|url',
            'link_social_youtube' => 'max:255|url',
            'link_social_google_plus' => 'max:255|url',
            'link_social_facebook' => 'max:255|url'
        ];
    }
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
        return array_merge(
            StoreGameRequest::storeRulesList(),
            StoreVersionRequest::$editableRulesList,
            StoreVersionRequest::$notEditableRulesList
        );
    }
}
