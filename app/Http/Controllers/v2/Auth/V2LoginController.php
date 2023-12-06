<?php

namespace App\Http\Controllers\v2\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\v2\Auth\V2LoginRequest;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class V2LoginController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \App\Http\Requests\v2\Auth\V2LoginRequest  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(V2LoginRequest $request)
    {
        try {
            $credentials = request(['email', 'password']);

            if (!Auth::attempt($credentials)) {
                throw new Exception('Invalid credentials');
            }

            $user = $request->user();

            $tokenResult = $user->createToken('Personal Access Token');

            $token = $tokenResult->token;

            $token->expires_at = Carbon::now()->addWeeks(4);

            $token->save();

            return response()->json([
                'access_token' => $tokenResult->accessToken,
                'token_type' => 'Bearer',
                'user' => $user
            ]);
        } catch (Exception $e) {
            Log::error($e);

            return response()->json([
                'message' => 'Failed to login',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
