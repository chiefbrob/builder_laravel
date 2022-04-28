<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Http\Requests\Blog\UpdateBlogRequest;
use App\Models\Blog;
use App\PhotoManager;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class UpdateBlogController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \App\Http\Requests\Blog\UpdateBlogRequest  $request
     * 
     * @param int $id
     * 
     * @return \Illuminate\Http\Response
     */
    public function __invoke(UpdateBlogRequest $request, $id)
    {
        try {
            $blog = Blog::findOrFail($id);

            $validated = $request->validated();
            unset($validated['default_image']);
            $blog->fill($validated);
            if ($request->hasFile('default_image')) {
                $default_image = $request->file('default_image');
                $blog->default_image =  PhotoManager::savePhoto(
                    $default_image,
                    'blog',
                    $blog->default_image
                );
            }
            $blog->save();
            $blog->refresh();
            return $blog;

        } catch (Exception $e) {
            Log::error($e);
            return response()->json([
                'message' => 'Failed to update blog'
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
