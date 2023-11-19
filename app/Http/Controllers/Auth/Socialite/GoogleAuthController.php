<?php

namespace App\Http\Controllers\Auth\Socialite;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\SendWelcomeEmailNotification;
use Exception;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class GoogleAuthController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            $user = User::where('email', $googleUser->email)->first();
            if (!$user) {
                $username = strtolower(
                    preg_replace('/[^a-zA-Z0-9]+/', '', $user->name)
                ).rand(1000, 9999);

                $pass = Str::random(16);

                $user = User::create(
                    [
                        'name' => $user->name,
                        'username' => $username,
                        'email' => $user->email,
                        'google_id'=> $user->id,
                        'password' => Hash::make($pass),
                    ]
                );

                event(new Registered($user));
                Notification::send($user, new SendWelcomeEmailNotification($user));
            }


            Auth::login($user);
            return redirect()->route('home');

        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(
                [
                    'message' => 'Failed to authenticate with google'
                ], Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }
    }
}
