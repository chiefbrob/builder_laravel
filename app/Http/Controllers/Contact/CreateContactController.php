<?php

namespace App\Http\Controllers\Contact;

use App\Http\Controllers\Controller;
use App\Http\Requests\Contact\ContactRequest;
use App\Models\Contact;
use App\PhotoManager;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class CreateContactController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \App\Http\Requests\Contact\ContactRequest  $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function __invoke(ContactRequest $request)
    {
        try {
            $validated = $request->validated();
            unset($validated['default_image']);
            $contact = Contact::create($validated);

            if ($request->hasFile('default_image')) {
                $default_image = $request->file('default_image');
                $contact->default_image =  PhotoManager::savePhoto(
                    $default_image,
                    'contacts',
                    $contact->default_image
                );
                $contact->save();
                
            }

            return $contact;

        } catch (Exception $e) {
            Log::error($e);
            return response()->json([
                'message' => 'Failed to create contact'
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
