<?php

namespace App\Repositories;

use App\Events\Invoices\InvoiceCreatedEvent;
use App\Http\Requests\Shop\CartCheckoutRequest;
use App\Http\Requests\UserProfileUpdateRequest;
use App\Models\Address;
use App\Models\Invoice;
use App\Models\ProductVariant;
use App\Models\Team;
use App\Models\User;
use App\Notifications\SendWelcomeEmailNotification;
use App\PhotoManager;
use Exception;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class UserRepository
{
    public function __construct(private User $user)
    {

    }

    public function update(UserProfileUpdateRequest $request): User
    {
        $user = $this->user;
        if ($request->phone_number !== $user->phone_number) {
            $user->phone_number_verified_at = null;
        }
        if ($request->username && $request->username !== $user->username) {
            $s = User::where('username', $request->username)->first();
            if ($s) {
                throw new Exception("Username already in use");
            }
            $user->username = $request->username;
        }
        $user->name = $request->name;
        $user->phone_number = $request->phone_number;
        if ($request->team_id) {
            $team = Team::findOrFail($request->team_id);
            if ($team->hasUser($user)) {
                $user->team_id = $team->id;
            } else {
                throw new Exception("User not member of team");
            }
        }

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $user->photo = PhotoManager::savePhoto(
                $photo,
                'profile',
                $user->photo
            );
        }

        $user->save();

        return $user;
    }
}