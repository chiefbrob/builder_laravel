<?php

namespace App\Http\Controllers\Admin\Roles;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddUserRoleRequest;
use App\Models\Role;
use App\Models\User;
use App\Models\UserRole;
use Exception;
use Illuminate\Http\Response;

class AddUserRoleController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param \App\Http\Requests\AddUserRoleRequest $request RQ
     * 
     * @return \Illuminate\Http\Response
     */
    public function __invoke(AddUserRoleRequest $request)
    {
        try {
            $userRole = UserRole::create($request->validated());
            return response()->json($userRole, Response::HTTP_CREATED);
        } catch( Exception $e) {
            \Log::error($e);
            return response()->json(
                ['message' => 'Failed to create user-role'], 
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }
    }
}
