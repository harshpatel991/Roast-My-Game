<?php

namespace App\Http\Requests;

use Auth;
use App\Http\Requests\Request;

class StoreCommentRequest extends Request
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
            'positive' => 'max:100|in:'. implode(',', array_keys(\App\Feedback::$feedbackCategories)),
            'negative' => 'max: 100|in:'. implode(',', array_keys(\App\Feedback::$feedbackCategories)),
            'body' => 'max: 5000'
        ];
    }
}
