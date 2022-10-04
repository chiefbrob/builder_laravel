<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Http\Requests\Blog\GetBlogsRequest;
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
     * @param  \App\Http\Requests\Blog\GetBlogsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(GetBlogsRequest $request)
    {
        try {
            // return $request->id;
            if ($request->id) {
                return Blog::where('id', $request->id)->with('user')->with('blogCategory')->first();
            }

            return Blog::with('blogCategory')->with('user')->paginate();
        } catch (Exception $e) {
            Log::error($e);

            return response()->json([
                'message' => 'Failed to fetch blogs',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
