<?php

namespace App\Models;

use App\Casts\MoneyCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'reference',
        'user_id',
        'cart',
        'address_id',
        'sub_total',
        'tax',
        'shipping_cost',
        'discount',
        'grand_total',
        'status',
        'payment_method_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'sub_total' => MoneyCast::class,
        'tax' => MoneyCast::class,
        'shipping_cost' => MoneyCast::class,
        'discount' => MoneyCast::class,
        'grand_total' => MoneyCast::class,
        'cart' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class)->withDefault(
            [
                'phone_number' => '-missing-',
                'street_address' => 'Unavailable',
            ]
        );
    }

    public function invoiceStates(): HasMany
    {
        return $this->hasMany(InvoiceState::class);
    }
}
