<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\CreateProductCategoryRequest;
use App\Models\ProductCategory;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class CreateProductCategoryController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(CreateProductCategoryRequest $request)
    {
        try {
            return ProductCategory::create($request->validated());
        } catch (Exception $e) {
            Log::error($e);

            return response()->json([
                'message' => 'Failed to create product category',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
