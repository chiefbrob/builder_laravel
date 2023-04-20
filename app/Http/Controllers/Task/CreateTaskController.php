<?php

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use App\Http\Requests\Task\CreateTaskRequest;
use App\Models\Task;
use App\Models\Team;
use App\Models\User;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class CreateTaskController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \App\Http\Requests\Task\CreateTaskRequest  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(CreateTaskRequest $request)
    {
        try {
            $user = User::findOrFail(auth()->id());
            $team = Team::findOrFail($request->team_id);
            if ($team->hasUser($user)) {
                if ($request->assigned_to) {
                    $assignee = User::findOrFail($request->assigned_to);
                    if (!$team->hasUser($assignee)) {
                        throw new Exception('Assignee not in team', 1);
                    }
                }
                $task = Task::create($request->validated());
                if ($task->team->shortcode) {
                    $task->shortcode = $task->team->shortcode . '-' . $task->id;
                    $task->save();
                }
                return response()->json([
                    'data' => $task,
                ], Response::HTTP_CREATED);
            }

            throw new Exception('Not Allowed', 1);
        } catch (Exception $e) {
            Log::error($e);

            return response()->json([
                'message' => 'Failed to create task',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
