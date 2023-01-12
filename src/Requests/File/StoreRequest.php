<?php

namespace Celysium\File\Requests\File;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'file' => ['required', 'file'],
            'description' => ['string',' max:255']
        ];
    }
}
