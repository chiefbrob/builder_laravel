<?php

namespace App\Http\Controllers\Address;

use App\Http\Controllers\Controller;
use App\Http\Requests\Address\GetAddressRequest;
use App\Models\Address;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class GetAddressController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(GetAddressRequest $request)
    {
        try {
            return Address::where('user_id', auth()->id())
                ->orderBy('id', 'DESC')
                ->paginate(4);
        } catch (Exception $e) {
            Log::error($e);
            return response()->json(
                [
                    'message' => 'Failed to fetch addresses'
                ], Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }
    }
}
