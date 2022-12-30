<?php

namespace Celysium\File\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateFileRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'image' => ['required', 'image', 'mimes:jpg,png,jpeg,gif,svg'], // TODO : file , delete images and use files
            'description' => ['string',' max:255']
        ];
    }
}
