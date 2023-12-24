<?php

namespace App\Http\Requests\v2\Contact;

use App\Models\Contact;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class V2GetContactsRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'statuses' => ['sometimes', 'nullable', 'array', 'min:1'],
            'statuses.*' => Rule::in(Contact::STATUSES),
        ];
    }
}
