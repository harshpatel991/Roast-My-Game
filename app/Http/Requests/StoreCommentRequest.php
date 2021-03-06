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

    public function messages()
    {
        return [
            'body.required'  => 'Please take a minute to add some details to your roast.',
            'body.min'       => 'Please take a minute to add a few more details to your roast, the game dev will really appreciate it!'
        ];
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
            'body' => 'max: 5000|required|min: 25'
        ];
    }
}
