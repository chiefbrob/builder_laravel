<?php

namespace App\Http\Controllers\Team;

use App\Http\Controllers\Controller;
use App\Http\Requests\Team\AddUserToTeamRequest;
use App\Models\Team;
use App\Models\User;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class AddUserToTeamController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \App\Http\Requests\Team\AddUserToTeamRequest  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(AddUserToTeamRequest $request, Int $team_id)
    {
        try {

            $team = Team::findOrFail($team_id);

            return $team->addUser(User::findOrFail($request->user_id));
        } catch (Exception $e) {
            Log::error($e);

            return response()->json([
                'message' => 'Failed to add user to team',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
