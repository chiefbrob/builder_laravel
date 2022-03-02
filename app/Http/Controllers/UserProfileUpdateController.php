<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserProfileUpdateRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
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
            $user = User::findOrFail($user_id);
            if ($request->phone_number !== $user->phone_number) {
                $user->phone_number_verified_at = null;
            }
            $user->fill($request->validated());
            
            return $user->save();
        }
        catch (Exception $e) {
            Log::error($e);
            return response()->json(
                ['message' => 'Failed to update profile'], Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }
    }
}
