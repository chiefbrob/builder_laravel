<?php

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use App\Http\Requests\Task\GetTaskTemplatesRequest;
use App\Models\TaskTemplate;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class GetTaskTemplatesController extends Controller
{
    public function __invoke(GetTaskTemplatesRequest $request)
    {
        try {
            $tts = TaskTemplate::query();
            if ($request->task_template_id) {
                $tts->where('id', $request->task_template_id)
                    ->whereIn('team_id', auth()->user()->myTeamIds);
            }
            if ($request->team_id) {
                $tts->where('team_id', $request->team_id)
                    ->whereIn('team_id', auth()->user()->myTeamIds);
            }

            if (!$request->team_id && !$request->task_template_id) {
                $tts->whereIn('team_id', auth()->user()->myTeamIds)
                    ->orWhereNull('team_id');
            }
            
            return $tts->orderBy('id', 'DESC')->paginate();
        } catch (Exception $e) {
            Log::error($e);
            return response()->json(
                ['message' => 'Failed to fetch task templates'], 
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }
    }
}
