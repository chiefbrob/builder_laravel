<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\ProductVariant;
use App\Repositories\CartRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class RemoveItemFromCartController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        try {
            $variant = ProductVariant::findOrFail($request->product_variant_id);
            $repo = new CartRepository();

            return response()->json(
                [
                    'cart' => $repo->removeFromCart($variant, $request->quantity),
                ]
            );
        } catch (Exception $e) {
            Log::error($e);

            return response()->json([
                'message' => 'Failed to remove item(s) from cart',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
