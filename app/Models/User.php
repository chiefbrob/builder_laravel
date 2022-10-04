<?php

namespace App\Models;

use App\Traits\CanBlog;
use App\Traits\HasRoles;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes, CanBlog;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'password',
        'photo',
        'language',
        'details',
    ];

    protected $appends = ['admin'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'details' => 'array',
    ];

    public function isAdmin()
    {
        $role = Role::where('name', 'admin')->firstOrCreate(['name' => 'admin']);

        return $this->hasRole($role) ? true : $this->email === 'brianobare@gmail.com';
    }

    public function getAdminAttribute()
    {
        return $this->isAdmin();
    }

    public function contacts(): HasMany
    {
        return $this->hasMany(Contact::class);
    }

    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class);
    }
}
