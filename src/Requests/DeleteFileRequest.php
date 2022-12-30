<?php

namespace Celysium\File\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeleteFileRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'files' => ['required', 'array'], // TODO : give ids
            'files.*' => ['string', 'max:255']
        ];
    }
}
