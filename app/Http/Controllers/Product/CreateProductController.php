<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\CreateProductRequest;
use App\Models\Product;
use App\PhotoManager;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class CreateProductController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \App\Http\Requests\Product\CreateProductRequest  $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function __invoke(CreateProductRequest $request)
    {
        try {
            $product = Product::create($request->validated());
            
            if ($request->hasFile('photo')) {
                $photo = $request->file('photo');
                $product->photo =  PhotoManager::savePhoto(
                    $photo,
                    'products',
                    $product->default_image
                );

                $product->save();
            }
            $product->refresh();
            return $product;
            
        } catch (Exception $e) {
            Log::error($e);
            return response()->json([
                'message' => 'Failed to create blog'
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
