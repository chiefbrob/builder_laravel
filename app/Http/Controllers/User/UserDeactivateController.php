<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserDeactivateController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, $user_id)
    {
        try {
            $user = User::findOrFail($user_id);
            if ($user->id === auth()->user()->id) {
                Auth::logout();
                $user->deactivated_at = now();

                return $user->save();
            }
            throw new Exception('User profile doesnt match', 1);
        } catch (Exception $e) {
            Log::error($e);

            return response()->json([
                'message' => 'Failed to delete user',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
