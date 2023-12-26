<?php

namespace App\Http\Requests\v2\Shop;

use App\Http\Requests\Shop\CartCheckoutRequest;

class V2CheckoutRequest extends CartCheckoutRequest
{
    public function rules()
    {
        return [
            'user_id' => [
                'sometimes',
                'nullable',
                'integer',
                'exists:users,id',
            ],
            'address_id' => [
                'sometimes',
                'nullable',
                'required_with:user_id',
                'integer',
                'exists:addresses,id',
            ],
            'phone_number' => [
                'sometimes',
                'nullable',
                'required_without:email,user_id',
                'string',
            ],
            'email' => [
                'sometimes',
                'nullable',
                'required_without:phone_number,user_id',
                'email',
            ],
            'payment_method_id' => [
                'required',
                'integer',
                'exists:payment_methods,id',
            ],
            'first_name' => [
                'exclude_with:user_id',
                'required',
                'string',
                'min:2',
                'max:20'
            ],
            'email' => [
                'exclude_with:user_id',
                'sometimes',
                'nullable',
                'email',
            ],
            'phone_number' => [
                'exclude_with:user_id',
                'required',
                'string',
            ],
            'street_address' => [
                'sometimes',
                'nullable',
                'string',
                'max:255',
            ],
            'cart' => [
                'required',
                'array',
                'min: 1'
            ],
            'cart.*.quantity' => [
                'required',
                'integer',
                'min:1'
            ],
            'cart.*.id' => [
                'required',
                'integer',
                'exists:product_variants,id'
            ]

        ];
    }

    protected function prepareForValidation(): void
    {
        if (auth('api')->user()) {
            $this->merge([
                'user_id' => auth('api')->user()->id,
            ]);
        }
    }
}
