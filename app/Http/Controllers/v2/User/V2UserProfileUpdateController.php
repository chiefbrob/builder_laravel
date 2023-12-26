<?php

namespace App\Http\Controllers\v2\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserProfileUpdateRequest;
use App\Http\Requests\v2\User\V2UserProfileUpdateRequest;
use App\Models\User;
use App\Repositories\UserRepository;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class V2UserProfileUpdateController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(UserProfileUpdateRequest $request)
    {
        try {
            $repo = new UserRepository(User::findOrFail(auth('api')->id()));
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
