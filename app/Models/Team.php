<?php

namespace App\Models;

use App\Traits\HasUsers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Team extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasUsers;

    protected $fillable = [
        'name',
        'email',
        'description',
        'user_id',
        'shortcode'
    ];

    protected $with = ['teamUsers'];

}
