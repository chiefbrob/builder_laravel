<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use HasFactory, SoftDeletes;

    const STATUS_PENDING = 'PENDING';

    const STATUS_QUEUED = 'QUEUED';

    const STATUS_IN_PROGRESS = 'IN_PROGRESS';

    const STATUS_COMPLETE = 'COMPLETE';

    const STATUSES = [
        self::STATUS_PENDING,
        self::STATUS_QUEUED,
        self::STATUS_IN_PROGRESS,
        self::STATUS_COMPLETE,
    ];

    protected $fillable = [
        'title',
        'email',
        'phone_number',
        'user_id',
        'contents',
        'default_image',
        'url',
        'status',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
