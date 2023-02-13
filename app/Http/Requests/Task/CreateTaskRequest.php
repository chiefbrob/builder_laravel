<?php

namespace App\Http\Requests\Task;

use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class CreateTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        \Log::info($this->all());
        return [
            'title' => 'string|required',
            'user_id' => 'integer|required|exists:users,id',
            'team_id' => 'integer|required|exists:teams,id',
            'description' => 'sometimes|nullable|string',
            'assigned_to' => 'sometimes|nullable|integer|exists:users,id',
            'status' => 'sometimes|nullable|string|in:open,ready,doing,reviewing,done,cancelled',
            'task_id' => 'sometimes|nullable|integer'
        ];
    }

    protected function prepareForValidation(): void
    {
        if (auth()->user()) {
            $this->merge([
                'user_id' => auth()->user()->id,
            ]);
        }
    }
}
