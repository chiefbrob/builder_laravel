<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\ProductsIndexRequest;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class ProductsIndexController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \App\Http\Requests\Product\ProductsIndexRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(ProductsIndexRequest $request)
    {
        try {
            if ($request->id) {
                return Product::findOrFail($request->id);
            }
            if ($query = $request->get('query')) {
                return Product::where('name', 'like', '%'.$query.'%')
                    ->orWhere('description', 'like', '%'.$query.'%')
                    ->with('productVariants')
                    ->paginate();
            }
            $products = Product::query();

            
            if ($request->get('featured', false)) {
                $featured = $request->featured === '1' ? true : false;
                $products->where('featured', $featured);
            }
            
            return $products->with('productVariants')
                ->whereHas(
                    'productVariants', function ($q) {
                        $q->where('quantity', '>', 0);
                    }
                )->paginate();
        } catch (Exception $e) {
            Log::error($e);

            return response()->json([
                'message' => 'Failed to fetch products',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
