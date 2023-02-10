<?php

namespace App\Http\Controllers\Team;

use App\Http\Controllers\Controller;
use App\Http\Requests\Team\TeamIndexRequest;
use App\Models\Team;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class TeamIndexController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \App\Http\Requests\Team\TeamIndexRequest  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(TeamIndexRequest $request, Int $team_id)
    {
        try {
            $team = Team::findOrFail($team_id);

            $user = auth()->user();

            if ($team->hasUser($user) || $user->isAdmin()) {
                return $team;
            }
            throw new Exception('User cannot view team', 1);
        } catch (Exception $e) {
            Log::error($e);

            return response()->json([
                'message' => 'Failed to get team',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
