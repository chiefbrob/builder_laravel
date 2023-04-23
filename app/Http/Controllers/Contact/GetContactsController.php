<?php

namespace App\Http\Controllers\Contact;

use App\Http\Controllers\Controller;
use App\Http\Requests\Contact\GetContactsRequest;
use App\Models\Contact;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class GetContactsController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \App\Http\Requests\Contact\GetContactsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(GetContactsRequest $request)
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

            return response()->json([
                'message' => 'Failed to fetch contacts',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
