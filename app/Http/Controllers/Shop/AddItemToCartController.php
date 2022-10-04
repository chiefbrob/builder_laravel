<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Http\Requests\Shop\AddItemToCartRequest;
use App\Models\ProductVariant;
use App\Repositories\CartRepository;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class AddItemToCartController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \App\Http\Requests\Shop\AddItemToCartRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(AddItemToCartRequest $request)
    {
        try {
            $variant = ProductVariant::findOrFail($request->product_variant_id);
            $repo = new CartRepository();

            return response()->json(
                [
                    'cart' => $repo->addToCart($variant, $request->quantity),
                ]
            );
        } catch (Exception $e) {
            Log::error($e);

            return response()->json([
                'message' => 'Failed to add product to cart',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
