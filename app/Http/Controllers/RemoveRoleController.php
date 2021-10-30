<?php

namespace App\Http\Controllers;

use App\Http\Requests\RemoveRoleRequest;
use App\Models\UserRole;
use Exception;
use Illuminate\Http\Response;

class RemoveRoleController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \App\Http\Requests\RemoveRoleRequest  $request
     * 
     * @param int $user_role_id
     * 
     * @return \Illuminate\Http\Response
     */
    public function __invoke(RemoveRoleRequest $request)
    {
        try {
            $userRole = UserRole::findOrFail($request->user_role_id);
            $userRole->delete();
            return response()->json(
                ['message' => 'user-role deleted']
            );
        } catch (Exception $e) {
            \Log::error($e);
            return response()->json(
                ['message' => 'Failed to delete user-role'], 
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }
    }
}
