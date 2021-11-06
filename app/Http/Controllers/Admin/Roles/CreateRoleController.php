<?php

namespace App\Http\Controllers\Admin\Roles;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateRoleRequest;
use App\Models\Role;
use Exception;
use Illuminate\Http\Response;

class CreateRoleController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \App\Http\Requests\CreateRoleRequest  $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function __invoke(CreateRoleRequest $request)
    {
        try {
            $role = Role::create($request->validated());
            return response()->json($role);
        } catch( Exception $e) {
            \Log::error($e);
            return response()->json(
                ['message' => 'Failed to create role'], 
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }
    }
}
