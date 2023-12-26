<?php

namespace App\Http\Controllers\v2\Shop;

use App\Http\Controllers\Controller;
use App\Http\Requests\v2\Shop\V2CheckoutRequest;
use App\Models\ProductVariant;
use App\Repositories\CartRepository;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class V2CheckoutController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(V2CheckoutRequest $request)
    {
        try {
            $inputs = $request->validated();
            $cart = $inputs['cart'];
            $newCart = [];
            foreach ($cart as $cartItem) {
                $variant = ProductVariant::findOrFail($cartItem['id']);
                $newCart[] = [
                    'id' => $variant->id,
                    'quantity' => $cartItem['quantity'],
                    'product_variant' => $variant,
                    'product' => $variant->product,
                ];
            }

            $repo = new CartRepository($newCart, true);

            return response()->json($repo->checkout($request));

        } catch( Exception $e) {
            Log::error($e);
            return response()->json(
                ['message' => 'Checkout Failed'], 
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }
    }
}
