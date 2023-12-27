<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\LoginBackToAdminRequest;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class LoginBackToAdminController extends Controller
{
    /**
     * Handle the incoming request.
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(LoginBackToAdminRequest $request)
    {
        try {
            $adminId = Session::get('admin-id');
            if (! $adminId) {
                throw new Exception('Cannot switch to admin, session missing');
            }
            Session::forget('admin-id');
            $response = Auth::loginUsingId($adminId);

            return response()->json(['message' => 'Login back to admin success']);
        } catch (Exception $e) {
            Log::error($e);

            return response()->json([
                'message' => 'Failed go back to admin',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
