<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'min:3', 'max:50'],
            'slug' => ['required', 'string', 'min:3', 'max:20'],
            'price' => ['required', 'integer', 'min:0'],
            'description' => ['required', 'string', 'max:200'],
            'photo' => ['sometimes', 'nullable', 'image', 'mimes:jpeg,jpg', 'max:2048'],
            'long_description' => ['sometimes', 'nullable', 'string']
        ];
    }
}
