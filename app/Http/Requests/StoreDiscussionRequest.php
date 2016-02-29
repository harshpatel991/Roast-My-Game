<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class StoreDiscussionRequest extends Request
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
        return [
            'title' => 'required|max:255',
            'category' => 'required|max: 255|in:'. implode(',', array_keys(\App\Discussion::$categories)),
            'content' => 'required|max: 5000'
        ];
    }
}
