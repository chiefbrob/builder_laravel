<?php

namespace App\Http\Controllers\Team;

use App\Http\Controllers\Controller;
use App\Http\Requests\Team\UpdateTeamRequest;
use App\Models\Team;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class UpdateTeamController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \App\Http\Requests\Team\UpdateTeamRequest  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(UpdateTeamRequest $request, Int $team_id)
    {
        try {
            $team = Team::findOrFail($team_id);
            $team->fill($request->validated());
            $team->save();
            return $team;
        } catch (Exception $e) {
            Log::error($e);

            return response()->json([
                'message' => 'Failed to update team',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
