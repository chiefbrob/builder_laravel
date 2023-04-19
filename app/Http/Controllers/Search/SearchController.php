<?php

namespace App\Http\Controllers\Search;

use App\Http\Controllers\Controller;
use App\Http\Requests\Search\SearchRequest;
use App\Models\Blog;
use App\Models\Product;
use App\Models\Task;
use App\Models\Team;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class SearchController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param \App\Http\Requests\Search\SearchRequest $request
     */
    public function __invoke(SearchRequest $request)
    {
        try {
            $products = Product::where('name', 'LIKE', '%'.$request->get('query').'%')->orderBy('id', "DESC")->limit(5)->get();
            $blogs = Blog::where('title', 'LIKE', '%'.$request->get('query').'%')->orderBy('id', "DESC")->limit(5)->get();

            $retVal = [
                'products' => $products,
                'blogs' => $blogs,
            ];

            if (auth()->id()) {
                $tasks = Task::where('title', 'LIKE', '%'.$request->get('query').'%')
                ->whereIn('team_id', auth()->user()->myTeamIds)
                    ->orderBy('id', "DESC")->limit(5)->get();

                $teams = Team::where('name', 'LIKE', '%'.$request->get('query').'%')
                    ->whereIn('id', auth()->user()->myTeamIds)
                    ->orderBy('id', "DESC")->limit(5)->get();
                $retVal['teams'] = $teams;
                $retVal['tasks'] = $tasks;
            }
            return $retVal;
        } catch (Exception $e) {
            Log::error($e);

            return response()->json([
                'message' => 'Failed to search',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
