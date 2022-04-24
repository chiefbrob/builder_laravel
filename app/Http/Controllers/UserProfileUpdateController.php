<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserProfileUpdateRequest;
use App\Models\User;
use Exception;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class UserProfileUpdateController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param \App\Http\Requests\UserProfileUpdateRequest $request 
     * 
     * @return \Illuminate\Http\Response
     */
    public function __invoke(UserProfileUpdateRequest $request, $user_id)
    {
        try {
            
            $user = User::findOrFail($user_id);
            if ($request->phone_number !== $user->phone_number) {
                $user->phone_number_verified_at = null;
            }
            $user->name = $request->name;
            $user->phone_number = $request->phone_number;

            if ($request->hasFile('photo')) {
                $photo = $request->file('photo');
                $fileName = time() . '.' . $photo->getClientOriginalExtension();
                

                $img = Image::make($photo->getRealPath());
                $img->resize(120, 120);

                $img->stream();

                $storage = Storage::disk('local')->put("public/images/profile/$fileName", $img, 'public');
                
                if ($storage) {
                    if ($user->photo) {
                        Storage::disk('local')
                            ->delete("public/images/profile/".$user->photo);
                    }
                    $user->photo = $fileName;
                }
                
            }
            
             $user->save();
             return $user;
        }
        catch (Exception $e) {
            Log::error($e);
            return response()->json(
                ['message' => 'Failed to update profile'], Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }
    }
}
