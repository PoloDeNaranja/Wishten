<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VideoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' =>  ['required', 'string', 'max:255'],
            'description'   =>  ['required', 'string', 'max:255'],
            'video' =>  ['required', 'mimes:mp4,x-flv,quicktime,x-msvideo,x-ms-wmv'],
            'thumbnail' =>  ['required', 'mimes:jpg,jpeg,png']
        ];
    }
}
