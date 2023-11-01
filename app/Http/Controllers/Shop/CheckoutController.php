<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Http\Requests\Shop\CheckoutRequest;
use App\Repositories\CartRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \App\Http\Requests\Shop\CheckoutRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(CheckoutRequest $request)
    {
        try {
            $repo = new CartRepository();

            return response()->json($repo->checkout($request));
        } catch (Exception $e) {
            Log::error($e);

            return response()->json([
                'message' => 'Failed to checkout',
                'details' => $e->getMessage(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
