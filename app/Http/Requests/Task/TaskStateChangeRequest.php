<?php

namespace App\Http\Requests\Task;

use App\Models\Task;
use Illuminate\Foundation\Http\FormRequest;

class TaskStateChangeRequest extends FormRequest
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
        return [
            'task_id' => 'required|integer|exists:tasks,id',
            'status' => 'sometimes|nullable|string|in:'. implode(',', Task::STATUSES),
            'assigned_to' => 'sometimes|nullable|integer|exists:users,id',
            'comments' => 'sometimes|nullable|string',
            'description' => 'sometimes|nullable|string',
            'notes' => 'sometimes|nullable|string',
            'title' => 'required|string',
        ];
    }
}
