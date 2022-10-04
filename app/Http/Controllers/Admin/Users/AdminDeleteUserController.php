<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Users\AdminDeleteUserRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class AdminDeleteUserController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \App\Http\Requests\Admin\Users\AdminDeleteUserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(AdminDeleteUserRequest $request)
    {
        try {
            $user = User::findOrFail($request->user_id);

            return $user->delete();
        } catch (Exception $e) {
            Log::error($e);

            return response()->json([
                'message' => 'Failed to get users',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
