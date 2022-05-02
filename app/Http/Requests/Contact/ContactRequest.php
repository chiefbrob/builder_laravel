<?php

namespace App\Http\Requests\Contact;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ContactRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|string|min:5',
            'email' => [ 'nullable', 'email',
                Rule::requiredIf(function() {
                    return empty($this->request->get('user_id')) && empty($this->request->get('phone_number'));
                })
            ],
            'phone_number' => 'sometimes|nullable|string|min:11',
            'user_id' => 'sometimes|nullable|integer|exists:users,id',
            'contents' => 'sometimes|nullable|string|min:5',
            'default_image' => 'sometimes|nullable|image|mimes:jpeg,jpg|max:2048',
            'url' => 'sometimes|nullable|string',
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
                'user_id' => auth()->user()->id
            ]);
        }
        
    }
}
