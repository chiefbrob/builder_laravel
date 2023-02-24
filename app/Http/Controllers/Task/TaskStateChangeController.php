<?php

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use App\Http\Requests\Task\TaskStateChangeRequest;
use App\Models\Task;
use App\Models\TaskStateChange;
use App\Models\User;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class TaskStateChangeController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \App\Http\Requests\Task\TaskStateChangeRequest  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(TaskStateChangeRequest $request, $task_id)
    {
        try {
            $task = Task::findOrFail($task_id);

            $user = User::findOrFail(auth()->id());

            if ($task->team->hasUser($user)) {
                $oldStatus = $task->status;

                if (isset($request->assigned_to)
                    && $request->assigned_to !== $task->assigned_to
                ) {
                    $assignee = User::findOrFail($request->assigned_to);

                    if (!$task->team->hasUser($assignee)) {
                        throw new Exception("Assignee Not Member of Team", 2);
                    }
                }

                $task->fill($request->validated());
                $task->save();

                if ($oldStatus !== $task->status) {
                    TaskStateChange::create(
                        [
                            'task_id' => $task->id,
                            'user_id' => $user->id,
                            'new_status' => $task->status,
                            'old_status' => $oldStatus,
                            'notes' => $request->get('notes', null),
                        ]
                    );
                }

                return $task;
            }

            throw new Exception("Not allowed", 1);
        } catch (Exception $e) {
            Log::error($e);

            return response()->json([
                'message' => 'Failed to update task',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
