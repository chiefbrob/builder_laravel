<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserIndexRequest;
use App\Models\Team;
use App\Models\User;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserIndexController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \App\Http\Requests\User\UserIndexRequest  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(UserIndexRequest $request)
    {
        try {
            $team = Team::findOrFail($request->team_id);

            return User::whereNotIn('id', $team->membersIds)->paginate();


        } catch (Exception $e) {
            Log::error($e);

            return response()->json([
                'message' => 'Failed to fetch users',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
