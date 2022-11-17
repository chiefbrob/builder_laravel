<?php

namespace App\Http\Requests\Blog;

use Illuminate\Foundation\Http\FormRequest;

class CreateBlogRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|string|min:5',
            'subtitle' => 'required|string|min:5',
            'user_id' => 'required|integer|exists:users,id',
            'contents' => 'required|string',
            'default_image' => 'required|image|mimes:jpeg,jpg|max:4096',
            'blog_category_id' => 'required|integer|exists:blog_categories,id',
        ];
    }
}
