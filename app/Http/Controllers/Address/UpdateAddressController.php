<?php

namespace App\Http\Controllers\Address;

use App\Http\Controllers\Controller;
use App\Http\Requests\Address\UpdateAddressRequest;
use App\Models\Address;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class UpdateAddressController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(UpdateAddressRequest $request, int $address_id)
    {
        try {
            $address = Address::where('user_id', auth()->id())
                ->where('id', $address_id)
                ->firstOrFail();
            $address->fill($request->validated());
            $address->save();
            if ($request->set_default) {
                $user = User::findOrFail(auth()->id());
                $user->default_address_id = $address->id;
                $user->save();
            }
            return $address;
        } catch (Exception $e) {
            Log::error($e);
            return response()->json(
                [
                    'message' => 'Failed to update address'
                ], Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }
    }
}
