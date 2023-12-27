<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Users\LoginAsUserRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LoginAsUserController extends Controller
{
    /**
     * Handle the incoming request.
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(LoginAsUserRequest $request)
    {
        try {
            $user = User::findOrFail($request->user_id);

            if ($user->id === auth()->id()) {
                throw new Exception('Already logged in');
            }
            session(['admin-id' => auth()->id()]);
            $response = Auth::login($user);

            return response()->json([
                'message' => 'Account Switch success',
            ]);
        } catch (Exception $e) {
            Log::error($e);

            return response()->json([
                'message' => 'Failed to login as user',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
