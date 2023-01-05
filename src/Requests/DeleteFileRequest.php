<?php

namespace Celysium\File\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeleteFileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false; // TODO : check permission
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'files' => ['required', 'array'],
            'files.*' => ['integer', 'exists:files,id'],
            'is_force_delete' => ['boolean']
        ];
    }
}
