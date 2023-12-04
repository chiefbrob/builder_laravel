<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvoiceState extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'invoice_id',
        'user_id',
        'previous_status',
        'status',
        'notes'
    ];

    public const STATUS_PENDING = 'PENDING';

    public const STATUS_PAID = 'PAID';

    public const STATUS_PROCESSING = 'PROCESSING';

    public const STATUS_DELIVERY = 'DELIVERY';

    public const STATUS_COMPLETE = 'COMPLETE';

    public const STATUS_CANCELLED = 'CANCELLED';

    public const STATUSES = [
        self::STATUS_PENDING,
        self::STATUS_PAID,
        self::STATUS_PROCESSING,
        self::STATUS_DELIVERY,
        self::STATUS_CANCELLED,
        self::STATUS_COMPLETE,
    ];

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'invoice_id' => $this->invoice_id,
            'user_id' => $this->user_id,
            'previous_status' => $this->previous_status,
            'status' => $this->status,
            'notes' => $this->notes,
            'user' => [
                'id' => $this->user_id,
                'name' => $this->user->name,
                'username' => $this->user->username
            ],
            'created_at' => $this->created_at
        ];
    }
}
