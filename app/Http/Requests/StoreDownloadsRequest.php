<?php

namespace App\Http\Requests;

use Auth;
use App\Http\Requests\Request;

class StoreDownloadsRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (Auth::check()) {
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
            'file_name_pc' => 'max:255',
            'link_input_pc' => 'url|max:255',
            'file_name_mac' => 'max:255',
            'link_input_mac' => 'url|max:255',
            'file_name_linux' => 'max:255',
            'link_input_linux' => 'url|max:255',
            'file_name_ios' => 'max:255',
            'link_input_ios' => 'url|max:255',
            'file_name_android' => 'max:255',
            'link_input_android' => 'url|max:255',
            'file_name_unity' => 'max:255',
            'link_input_unity' => 'url|max:255',
            'file_name_other' => 'max:255',
            'link_input_other' => 'url|max:255'
        ];
    }
}
