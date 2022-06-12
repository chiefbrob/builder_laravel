<?php

namespace App\Models;

use App\Casts\MoneyCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
        'payment_method_id'
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

    
}
