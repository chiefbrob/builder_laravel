<?php

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use App\Http\Requests\Task\TaskIndexRequest;
use App\Models\Task;
use App\Models\User;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class TaskIndexController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \App\Http\Requests\Task\TaskIndexRequest  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(TaskIndexRequest $request)
    {
        try {
            $user = User::findOrFail(auth()->id());

            if (isset($request->task_id)) {
                $task = Task::findOrFail($request->task_id);

                if ($task->team->hasUser($user)) {
                    return $task;
                }
                throw new Exception("Not Allowed", 1);
            }

            $tasks = Task::where('team_id', $request->team_id)->whereNull('task_id')->whereIn('team_id', $user->myTeamIds);

            if (isset($request->status)) {
                $tasks->whereIn('status', $request->status);
            }

            if (isset($request->assigned_to)) {
                $tasks->whereIn('assigned_to', $request->assigned_to);
            }

            if (isset($request->period_start) && isset($request->period_end)) {
                // $tasks->where();
                
            }

            return $tasks->orderBy($request->get('orderBy', 'id'), $request->get('orderDirection', 'DESC'))
                ->paginate();
        } catch (Exception $e) {
            Log::error($e);

            return response()->json([
                'message' => 'Failed to get task(s)',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
