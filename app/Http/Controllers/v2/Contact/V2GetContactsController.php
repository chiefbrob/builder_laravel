<?php

namespace App\Http\Controllers\v2\Contact;

use App\Http\Controllers\Controller;
use App\Http\Requests\v2\Contact\V2GetContactsRequest;
use App\Models\Contact;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class V2GetContactsController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(V2GetContactsRequest $request)
    {
        try {
            $contacts = Contact::query();
            $statuses = $request->get('statuses');


            if ($statuses) {
                $contacts = Contact::whereIn('status', $statuses);
            }


            if (! auth()->user()->isAdmin()) {
                $contacts->where('user_id', auth()->id());
            }

            return response()->json($contacts->orderBy('id', 'DESC')->paginate());

        } catch (Exception $e) {
            Log::error($e);
            return response()
                ->json(
                    ['message' => 'Failed to get contacts'],
                    Response::HTTP_UNPROCESSABLE_ENTITY
                );
        }
    }
}
