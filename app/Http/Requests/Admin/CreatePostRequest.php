<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CreatePostRequest extends FormRequest
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
            'title' => ['required', 'string', 'min:2', 'max:255', 'unique:catalogs,title'],
            'description' => ['required', 'string', 'min:2', 'max:255'],
            'content' => ['required', 'string', 'min:2', 'max:255'],
            'thumbnail' => ['nullable', 'image'],
            'published' => ['required', 'boolean'],
            'author_id' => ['required', 'exists:users,id'],
            'catalog_id' => ['required', 'exists:catalogs,id']
        ];
    }
}
