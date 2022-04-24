<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Http\Requests\Blog\CreateBlogRequest;
use App\Models\Blog;
use Exception;
use Illuminate\Http\Response;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class CreateBlogController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \App\Http\Requests\Blog\CreateBlogRequest  $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function __invoke(CreateBlogRequest $request)
    {
        return $request->all();
        try {
            $blog = Blog::create($request->validated());
            if ($request->hasFile('default_image')) {
                $photo = $request->file('default_image');
                $fileName = time() . '.' . $photo->getClientOriginalExtension();
                

                $img = Image::make($photo->getRealPath());
                $img->resize(120, 120);

                $img->stream();

                $storage = Storage::disk('local')->put("public/images/blog/$fileName", $img, 'public');
                
                if ($storage) {
                    
                    $blog->default_image = $fileName;
                }

                $blog->save();
            }
            $blog->refresh();
            return $blog;
            
        } catch (Exception $e) {
            Log::error($e);
            return response()->json([
                'message' => 'Failed to create blog'
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
