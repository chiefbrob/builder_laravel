<?php

namespace App\Http\Requests\Admin\Categories;

use Illuminate\Foundation\Http\FormRequest;

class AdminCreateCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:3', 'max:20'],
            'slug' => ['required', 'string', 'min:3', 'max:20', 'unique:categories,slug'],
            'description' => ['string'],
        ];
    }

    public function prepareForValidation()
    {
        if (!$this->slug && $this->name) {
            $this->merge([
                'slug' => slugify($this->name),
            ]);
        }
    }
}
