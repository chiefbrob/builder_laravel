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
            $task = Task::create($request->validated());
            return response()->json([
                'data' => $task,
            ], Response::HTTP_CREATED);

        } catch (Exception $e) {
            Log::error($e);

            return response()->json([
                'message' => 'Failed to create task',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
