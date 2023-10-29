<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Http\Requests\Shop\ShopProductsIndexRequest;
use App\Models\Product;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class ShopProductsIndexController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(ShopProductsIndexRequest $request)
    {
        try {
            $products = Product::query();
            if ($request->deleted) {
                $products->withTrashed();
            }
            return $products->with('productVariants')
                ->orderBy('name')->paginate();
        } catch (Exception $e) {
            Log::error($e);

            return response()->json([
                'message' => 'Failed to fetch shop products',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
