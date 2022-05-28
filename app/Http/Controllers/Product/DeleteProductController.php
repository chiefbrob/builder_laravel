<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\DeleteProductRequest;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DeleteProductController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \App\Http\Requests\Product\DeleteProductRequest  $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function __invoke(DeleteProductRequest $request, int $id)
    {
        try {
            $product = Product::findOrFail($id);
            return $product->delete();
            
        } catch (Exception $e) {
            Log::error($e);
            return response()->json([
                'message' => 'Failed to delete product'
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
