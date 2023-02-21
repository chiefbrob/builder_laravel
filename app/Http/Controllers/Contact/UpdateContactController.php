<?php

namespace App\Http\Controllers\Contact;

use App\Http\Controllers\Controller;
use App\Http\Requests\Contact\UpdateContactRequest;
use App\Models\Contact;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class UpdateContactController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \App\Http\Requests\Contact\UpdateContactRequest  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(UpdateContactRequest $request)
    {
        try {
            $contact = Contact::findOrFail($request->contact_id);
            $contact->fill($request->validated());
            $contact->save();

            return $contact;
        } catch (Exception $e) {
            Log::error($e);

            return response()->json([
                'message' => 'Failed to update contacts',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
