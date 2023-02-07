<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMusicRequest extends FormRequest
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
            'title'=>'string|nullable',
            'spotify_id'=>'string|nullable',
            'info'=>'string|nullable',
            'link'=>'string',
            'text'=>'string|nullable',
            'poster'=>'string',
            'genre_id'=>'',
            'user_id'=>'',
            'playlist_id'=>'',
        ];
    }
}
