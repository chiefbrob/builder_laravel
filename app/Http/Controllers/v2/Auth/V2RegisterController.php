<?php

namespace App\Http\Controllers\v2\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\v2\Auth\V2RegisterRequest;
use App\Models\User;
use Exception;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class V2RegisterController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(V2RegisterRequest $request)
    {
        try {
            $values = $request->validated();
            if (!$request->username) {
                $values['username'] = User::createUsername($request->name);
            }
            $values['password'] = Hash::make($request->password);
            $user =  User::create($values);

            event(new Registered($user));

            return response()->json($user, Response::HTTP_CREATED);
        } catch (Exception $e) {
            Log::error($e);
            return response()->json(
                ['message' => 'Failed to register'], 
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }
    }
}
