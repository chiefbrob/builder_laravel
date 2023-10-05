<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\CreateProductVariantRequest;
use App\Models\ProductVariant;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class CreateProductVariantController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(CreateProductVariantRequest $request, int $product_id)
    {
        
            return ProductVariant::create(
                array_merge(
                    $request->validated(), 
                    [
                        'product_id' => $product_id
                    ]
                )
            );
            try {
        } catch (Exception $e) {
            Log::error($e);

            return response()->json(
                [
                    'message' => 'Failed to create product variant',
                ], 
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }
    }
}
