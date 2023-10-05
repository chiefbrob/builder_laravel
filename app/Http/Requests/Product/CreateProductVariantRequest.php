<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductVariantRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required', 
                'string',
            ],
            'variant_id' => [
                'sometimes', 
                'nullable', 
                'integer', 
                'exists:product_variants,id'
            ],
            'description' => [
                'sometimes', 
                'nullable', 
                'string',
            ],
            'photo' => [
                'sometimes', 
                'nullable', 
                'image', 
                'mimes:jpeg,jpg,png', 
                'max:2048'
            ],
            'quantity' => [
                'required',
                'integer',
                'min: 0',
            ],
            'product_size_id' => [
                'nullable',
                'sometimes',
                'integer',
                'exists:product_sizes,id'
            ]
        ];
    }
}
