<?php

namespace App\Http\Requests;

use Auth;
use App\Http\Requests\Request;

class StoreVersionRequest extends Request
{

    static $editableRulesList = [
        'version' => 'required|max:255',
        'beta' => 'max:10',
        'video_link' => 'max:255|url',
        'link_platform_pc' => 'max:255|url',
        'link_platform_mac' => 'max:255|url',
        'link_platform_ios' => 'max:255|url',
        'link_platform_android' => 'max:255|url',
        'link_platform_unity' => 'max:255|url',
        'link_platform_other' => 'max:255|url',

        'upcoming_features' => 'max:5000',
        'changes' => 'max:5000'
        ];

    static $notEditableRulesList = [
        'image1' => 'required|image|max:2000',
        'image2' => 'image|max:2000',
        'image3' => 'image|max:2000',
        'image4' => 'image|max:2000',
    ];
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
            StoreVersionRequest::$editableRulesList,
            StoreVersionRequest::$notEditableRulesList);
    }
}
