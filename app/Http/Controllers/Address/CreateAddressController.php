<?php

namespace App\Http\Controllers\Address;

use App\Http\Controllers\Controller;
use App\Http\Requests\Address\CreateAddressRequest;
use App\Models\Address;
use App\Models\User;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class CreateAddressController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(CreateAddressRequest $request)
    {
        try {
            $address = Address::create($request->validated());
            if (!auth()->user()->defaultAddress) {
                $user = User::findOrFail(auth()->id());
                $user->default_address_id =  $address->id;
                $user->save();
            }
            return response()->json($address, Response::HTTP_CREATED);
        } catch (Exception $e) {
            Log::error($e);
            return response()->json(
                [
                    'message' => 'Failed to create address'
                ], Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }
    }
}
