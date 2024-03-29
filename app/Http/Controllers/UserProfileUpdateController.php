<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserProfileUpdateRequest;
use App\Models\Team;
use App\Models\User;
use App\PhotoManager;
use App\Repositories\UserRepository;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class UserProfileUpdateController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \App\Http\Requests\UserProfileUpdateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(UserProfileUpdateRequest $request, $user_id)
    {
        try {
            $repo = new UserRepository(User::findOrFail($user_id));
            return $repo->update($request);
        } catch (Exception $e) {
            Log::error($e);

            return response()->json(
                ['message' => 'Failed to update profile'],
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }
    }
}
