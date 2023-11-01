<?php

namespace App\Http\Requests\Shop;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
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
            ]

        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation(): void
    {
        if (auth()->user()) {
            $this->merge([
                'user_id' => auth()->user()->id,
            ]);
        }
    }
}
