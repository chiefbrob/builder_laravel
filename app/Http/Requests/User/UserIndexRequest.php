<?php

namespace App\Http\Requests\User;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class UserIndexRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $manager = Role::firstOrCreate(['name' => 'manager']);
        $user = User::findOrFail(auth()->id());
        return $user->isAdmin() || $user->hasRole($manager);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'team_id' => 'required|integer|exists:teams,id'
        ];
    }
}
