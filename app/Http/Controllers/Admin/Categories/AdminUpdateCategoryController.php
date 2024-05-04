<?php

namespace App\Http\Controllers\Admin\Categories;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Categories\AdminUpdateCategoryRequest;
use App\Models\Category;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class AdminUpdateCategoryController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(AdminUpdateCategoryRequest $request, int $category_id)
    {
        try {
           $category = Category::findOrFail($category_id);

           $category->fill($request->validated());

           $category->save();

           return $category;
           
        } catch (Exception $e) {
            Log::error($e);

            return response()->json([
                'message' => 'Failed to update category',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
