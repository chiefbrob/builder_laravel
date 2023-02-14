<?php

namespace App\Http\Controllers\Admin\Roles;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Roles\GetRolesRequest;
use App\Models\Role;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class GetRolesController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \App\Http\Requests\Admin\Roles\GetRolesRequest  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(GetRolesRequest $request)
    {
        try {
            if (isset($request->role_id)) {
                return Role::findOrFail($request->role_id);
            }
            return Role::paginate();
        } catch(Exception $e) {
            Log::error($e);

            return response()->json(
                ['message' => 'Failed to get role(s)'],
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }
    }
}
