<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\UpdateProductVariantRequest;
use App\Models\ProductVariant;
use App\PhotoManager;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class UpdateProductVariantController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(
        UpdateProductVariantRequest $request, 
        int $product_id, 
        int $product_variant_id
    ) {
        try {
            $productVariant = ProductVariant::findOrFail($product_variant_id);

            $validated = $request->validated();
            unset($validated['photo']);

            $productVariant->fill($validated);
            $productVariant->save();

            if ($request->hasFile('photo')) {
                $photo = $request->file('photo');
                $productVariant->photo = PhotoManager::savePhoto(
                    $photo,
                    'product-variants',
                    $productVariant->photo,
                    true,
                    800,
                    600
                );

                $productVariant->save();
            }
            $productVariant->refresh();
            return $productVariant;

        } catch (Exception $e) {
            Log::error($e);

            return response()->json([
                'message' => 'Failed to update product variant',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
