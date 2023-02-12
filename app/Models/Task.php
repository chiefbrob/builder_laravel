<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory, SoftDeletes;

    public const OPEN = 'open';
    public const READY = 'ready';
    public const DOING = 'doing';
    public const REVIEWING = 'reviewing';
    public const DONE = 'done';
    public const CANCELLED = 'cancelled';

    public const STATUSES = [
        self::OPEN,
        self::READY,
        self::DOING,
        self::REVIEWING,
        self::DONE,
        self::CANCELLED,
    ];

    protected $fillable = [
        'title',
        'description',
        'team_id',
        'user_id',
        'assigned_to',
        'status',
        'task_id'
    ];

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getAssigneeAttribute()
    {
        if ($this->assigned_to) {
            return User::findOrFail($this->assigned_to);
        }
        return null;
    }

    public function taskStateChanges(): HasMany
    {
        return $this->hasMany(TaskStateChange::class);
    }

}
