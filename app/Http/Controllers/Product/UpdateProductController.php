<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Models\Product;
use App\PhotoManager;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UpdateProductController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \App\Http\Requests\Product\UpdateProductRequest  $request
     * @param  int  $id
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
                    $product->photo
                );

                $product->save();
            }
            $product->save();
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
