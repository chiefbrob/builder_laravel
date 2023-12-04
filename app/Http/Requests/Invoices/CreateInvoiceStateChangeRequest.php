<?php

namespace App\Http\Requests\Invoices;

use App\Models\InvoiceState;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateInvoiceStateChangeRequest extends FormRequest
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
            'invoice_id' => ['required', 'integer', 'exists:invoices,id'],
            'status' => ['required','string', Rule::in(InvoiceState::STATUSES)],
            'notes' => ['sometimes', 'nullable', 'string'],
            'user_id' => ['required', 'integer', 'exists:users,id']
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'user_id' => auth()->id(),
        ]);
    }
}
