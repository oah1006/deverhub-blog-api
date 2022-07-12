<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
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
            'title' => ['sometimes', 'string', 'min:2', 'max:255', 'unique:catalogs,title'],
            'description' => ['sometimes', 'string', 'min:2', 'max:255'],
            'content' => ['sometimes', 'string', 'min:2', 'max:255'],
            'thumbnail' => ['sometimes', 'image'],
            'published' => ['sometimes', 'boolean'],
            'author_id' => ['sometimes', 'exists:users,id'],
            'catalog_id' => ['sometimes', 'exists:catalogs,id']
        ];
    }
}
