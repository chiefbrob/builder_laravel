<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class GetBlogsController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        try {
            if ($request->id) {
                return Blog::findOrFail($request->id)->with('blogCategory')->first();
            }
            return Blog::with('blogCategory')->paginate();
            
        } catch (Exception $e) {
            Log::error($e);
            return response()->json([
                'message' => 'Failed to fetch blogs'
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
