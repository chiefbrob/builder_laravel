<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\CreateProductVariantRequest;
use App\Models\ProductVariant;
use App\PhotoManager;
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
        try { 
            $variant =  ProductVariant::create(
                array_merge(
                    $request->validated(), 
                    [
                        'product_id' => $product_id
                    ]
                )
            );

            if ($request->hasFile('photo')) {
                $photo = $request->file('photo');
                $variant->photo = PhotoManager::savePhoto(
                    $photo,
                    'product-variants',
                    $variant->photo,
                    true,
                    800,
                    600
                );

                $variant->save();
            }
            $variant->refresh();
            return $variant;
            
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
