<?php

namespace App\Http\Controllers\Admin\Categories;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Categories\AdminCreateCategoryRequest;
use App\Models\Category;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class AdminCreateCategoryController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(AdminCreateCategoryRequest $request)
    {
        try {
            return Category::create($request->validated());
        } catch (Exception $e) {
            Log::error($e);

            return response()->json([
                'message' => 'Failed to create category',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
