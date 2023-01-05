<?php

namespace App\File\src\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AttachRequest extends FormRequest
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
            'file_id' => ['required', 'exists:files,id'],
            'model' => ['required', 'string'],
            'model_ids' => ['required', 'array'],
            'model_ids.*' => ['integer'],
        ];
    }
}
