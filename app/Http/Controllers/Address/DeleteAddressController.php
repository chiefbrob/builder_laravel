<?php

namespace App\Http\Controllers\Address;

use App\Http\Controllers\Controller;
use App\Http\Requests\Address\DeleteAddressRequest;
use App\Models\Address;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class DeleteAddressController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(DeleteAddressRequest $request, int $address_id)
    {
        try {
            $user = User::findOrFail(auth()->id());
            $address = Address::where('user_id', $user->id)
                ->where('id', $address_id)
                ->firstOrFail();
            if ($user->default_address_id === $address_id) {
                $user->default_address_id = null;
                $user->save();
            }
            $address->delete();
            return response()->json(
                ['message' => 'Address Deleted'], 
                Response::HTTP_OK
            );
        } catch (Exception $e) {
            Log::error($e);
            return response()->json(
                ['message' => 'failed to delete address'],
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }
    }
}
