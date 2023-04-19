<?php

namespace App\Http\Controllers\Team;

use App\Http\Controllers\Controller;
use App\Http\Requests\Team\TeamIndexRequest;
use App\Models\Team;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
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
    public function __invoke(TeamIndexRequest $request)
    {
        try {
            $team_id = $request->team_id;
            $user = auth()->user();

            if (!$team_id) {
                $teams = Team::where('id', '>', 0);
                if (!$user->isAdmin()) {
                    $teams->whereIn('id', $user->myTeamIds);
                }

                $admin = $request->get('admin', null);

                if ($admin) {
                    $teams->where('user_id', auth()->id());
                }

                return $teams->orderBy('name')->paginate();


            }
            $team = Team::findOrFail($team_id);

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
