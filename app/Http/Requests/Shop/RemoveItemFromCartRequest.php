<?php

namespace App\Http\Requests\Shop;

use Illuminate\Foundation\Http\FormRequest;

class RemoveItemFromCartRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'product_variant_id' => [
                'required', 
                'integer', 
                'exists:product_variants,id'
            ],
            'quantity' => [
                'required',
                'integer',
                'min:1'
            ]
        ];
    }

    protected function prepareForValidation(): void
    {
        if (!$this->quantity) {
            $this->merge([
                'quantity' => 1,
            ]);
        }
    }
}
