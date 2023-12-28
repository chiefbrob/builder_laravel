<?php

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use App\Http\Requests\Task\CreateTaskFromTemplateRequest;
use App\Models\Task;
use App\Models\TaskTemplate;
use App\Models\Team;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class CreateTaskFromTemplateController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(CreateTaskFromTemplateRequest $request)
    {
        try {
            $team = Team::where('id', $request->team_id)
                ->whereIn('id', auth()->user()->myTeamIds)
                ->firstOrFail();
            $tt = TaskTemplate::where('id', $request->task_template_id)
                ->firstOrFail();

            return Task::createFromTemplate($tt, $team, auth()->user());
        
        } catch (Exception $e) {
            Log::error($e);
            return response()->json(
                [
                    'message' => 'Task Template use Failed!'
                ],
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }
    }
}
