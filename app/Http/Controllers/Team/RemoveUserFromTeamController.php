<?php

namespace App\Http\Controllers\Team;

use App\Http\Controllers\Controller;
use App\Http\Requests\Team\RemoveUserFromTeamRequest;
use App\Models\Team;
use App\Models\User;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class RemoveUserFromTeamController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(RemoveUserFromTeamRequest $request, $team_id)
    {
        try {
            $team = Team::findOrFail($team_id);

            return $team->removeUser(User::findOrFail($request->user_id));
        } catch (Exception $e) {
            Log::error($e);

            return response()->json([
                'message' => 'Failed to remove user to team',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
