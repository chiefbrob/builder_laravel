<?php

namespace App\Http\Requests\Task;

use App\Models\Task;
use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class TaskIndexRequest extends FormRequest
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
            'team_id' => 'required|integer|exists:teams,id',
            'status' => 'sometimes|nullable|array',
            'status.*' => 'sometimes|nullable|string',
            'assigned_to' => 'sometimes|nullable|integer',
            'task_id' => 'sometimes|nullable|integer|exists:tasks,id'
        ];
    }
}
