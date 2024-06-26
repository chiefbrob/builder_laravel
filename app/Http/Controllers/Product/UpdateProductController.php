<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Models\Product;
use App\Models\ProductCategory;
use App\PhotoManager;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class UpdateProductController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \App\Http\Requests\Product\UpdateProductRequest  $request
     * @param  int  $id
     * 
     * @return \Illuminate\Http\Response
     */
    public function __invoke(UpdateProductRequest $request, $id)
    {
        try {
            $product = Product::findOrFail($id);

            $validated = $request->validated();
            unset($validated['photo']);
            $product->fill($validated);
            if ($request->hasFile('photo')) {
                $photo = $request->file('photo');
                $product->photo = PhotoManager::savePhoto(
                    $photo,
                    'products',
                    $product->photo,
                    true,
                    800,
                    600
                );

                $product->save();
            }
            $product->save();
            $product->refresh();

            ProductCategory::where('product_id', $product->id)->delete();
            if ($request->categories) {
                foreach ($request->categories as $category) {
                    ProductCategory::create(['product_id'=> $product->id, 'category_id' => $category]);
                }
            }

            $product->refresh();

            return $product;
        } catch (Exception $e) {
            Log::error($e);

            return response()->json([
                'message' => 'Failed to update product',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
