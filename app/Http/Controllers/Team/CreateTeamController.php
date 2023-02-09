<?php

namespace App\Http\Controllers\Team;

use App\Http\Controllers\Controller;
use App\Http\Requests\Team\CreateTeamRequest;
use App\Models\Team;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class CreateTeamController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \App\Http\Requests\Team\CreateTeamRequest  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(CreateTeamRequest $request)
    {
        try {
            return Team::create($request->validated());
        } catch (Exception $e) {
            Log::error($e);

            return response()->json([
                'message' => 'Failed to create team',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
