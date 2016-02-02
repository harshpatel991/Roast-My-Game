<?php

namespace App\Http\Requests;

use Auth;
use App\Http\Requests\Request;

class StoreCommentReplyRequest extends Request
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
            'body.required'  => 'The comment field is required.',
            'body.min' => 'The comment must be at least 5 characters.'
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
            'body' => 'max: 5000|required|min: 5'
        ];
    }
}
