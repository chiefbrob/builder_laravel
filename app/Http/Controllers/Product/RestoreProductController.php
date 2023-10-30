<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\RestoreProductRequest;
use App\Models\Product;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class RestoreProductController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(RestoreProductRequest $request, int $product_id)
    {
        try {
            $product = Product::withTrashed()->findOrFail($product_id);
            if ($product->restore()) {
                return response()->json(['message' => 'success']);
            }
            throw new Exception('could not restore product '. $product->id);
        } catch (Exception $e) {
            Log::error($e);

            return response()->json([
                'message' => 'Failed to restore product',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
