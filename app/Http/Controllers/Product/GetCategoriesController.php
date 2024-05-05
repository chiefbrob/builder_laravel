<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GetCategoriesController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        try {
            return Category::orderBy('name')->paginate();
        } catch (Exception $e) {
            Log::error($e);

            return response()->json([
                'message' => 'Failed to get categories',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
