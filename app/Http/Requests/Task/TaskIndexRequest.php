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
        $user = auth()->user();
        $team = Team::findOrFail($this->team_id);
        return [
            'team_id' => 'required|integer|exists:teams,id|in:'.implode(',', $user->myTeamIds),
            'status' => 'sometimes|nullable|string|in:'. implode(',', Task::STATUSES),
            'assigned_to' => 'sometimes|nullable|integer|in:'. implode(',', $team->membersIds)
        ];
    }
}
