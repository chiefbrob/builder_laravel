<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminGetUsersRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class AdminGetUsersController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \App\Http\Requests\Admin\AdminGetUsersRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(AdminGetUsersRequest $request)
    {
        try {
            $users = User::paginate(15);

            $users->withPath('/admin/users');

            return $users;
        } catch (Exception $e) {
            Log::error($e);

            return response()->json([
                'message' => 'Failed to get users',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
