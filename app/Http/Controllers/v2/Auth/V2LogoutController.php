<?php

namespace App\Http\Controllers\v2\Auth;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class V2LogoutController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        try {
            $request->user('api')->token()->revoke();
            return ['message' => 'logged out'];
        } catch (Exception $e) {
            Log::error($e);

            return response()->json([
                'message' => 'Failed to logout',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
