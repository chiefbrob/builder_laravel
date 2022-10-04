<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Http\Requests\Blog\CreateBlogRequest;
use App\Models\Blog;
use App\PhotoManager;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class CreateBlogController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \App\Http\Requests\Blog\CreateBlogRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(CreateBlogRequest $request)
    {
        try {
            $blog = Blog::create($request->validated());

            if ($request->hasFile('default_image')) {
                $default_image = $request->file('default_image');
                $blog->default_image = PhotoManager::savePhoto(
                    $default_image,
                    'blog',
                    $blog->default_image,
                    false
                );

                $blog->save();
            }
            $blog->refresh();

            return $blog;
        } catch (Exception $e) {
            Log::error($e);

            return response()->json([
                'message' => 'Failed to create blog',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
