<?php

namespace App\Http\Controllers\v2\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class V2DeleteAccountController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        try {
            $user = auth('api')->user();
            $user = User::findOrFail(auth('api')->user()->id);
            return $user->delete();
        } catch (Exception $e) {
            Log::error($e);
            return response()->json(
                ['message' => 'failed to delete account v2'],
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }
    }
}
