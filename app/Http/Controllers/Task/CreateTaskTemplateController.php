<?php

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use App\Http\Requests\Task\CreateTaskTemplateRequest;
use App\Models\Task;
use App\Models\TaskTemplate;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class CreateTaskTemplateController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(CreateTaskTemplateRequest $request)
    {
        try {
            $task = Task::where('id', $request->task_id)
                ->whereIn('team_id', auth()->user()->myTeamIds)
                ->firstOrFail();
            $validated = $request->validated();
            $validated['config'] = $task->toArray();
            
            return TaskTemplate::create($validated);
            
        } catch (Exception $e) {
            Log::error($e);
            return response()->json(
                ['message' => 'Faile to create Task Template'],
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }
    }
}
