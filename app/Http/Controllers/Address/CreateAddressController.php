<?php

namespace App\Http\Controllers\Address;

use App\Http\Controllers\Controller;
use App\Http\Requests\Address\CreateAddressRequest;
use App\Models\Address;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CreateAddressController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(CreateAddressRequest $request)
    {
        try {
            return Address::create($request->validated());
        } catch (Exception $e) {
            Log::error($e);
            return response()->json(
                [
                    'message' => 'Failed to create address'
                ]
            );
        }
    }
}
