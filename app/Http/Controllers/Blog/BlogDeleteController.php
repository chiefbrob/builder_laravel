<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Http\Requests\Blog\BlogDeleteRequest;
use App\Models\Blog;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class BlogDeleteController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \App\Http\Requests\Blog\BlogDeleteRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(BlogDeleteRequest $request, int $id)
    {
        try {
            $blog = Blog::findOrFail($id);

            return $blog->delete();
        } catch (Exception $e) {
            Log::error($e);

            return response()->json([
                'message' => 'Failed to delete blog',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
