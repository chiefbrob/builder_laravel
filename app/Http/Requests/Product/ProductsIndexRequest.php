<?php

namespace App\Http\Requests\Product;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;

class ProductsIndexRequest extends FormRequest
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
            'id' => 'nullable|sometimes|integer|exists:products,id',
            'query' => 'nullable|sometimes|string|min:3',
            'slug' => 'nullable|sometimes|string|exists:products,slug',
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation(): void
    {
        if ($this->slug) {
            $product = Product::where('slug', $this->slug)->firstOrFail();
            $this->merge([
                'id' => $product->id,
            ]);
        }
    }
}
