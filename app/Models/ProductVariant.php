<?php

namespace App\Models;

use App\Models\Shop\Variants;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductVariant extends Variants
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'product_id',
        'variant_id',
        'name',
        'description',
        'photo',
        'quantity',
        'product_size_id',
    ];

    protected $appends = [ 'variants'];

    public function getParentAttribute() : Variants
    {
        if ($this->variant_id) {
            return ProductVariant::findOrFail($this->variant_id);
        }
        return $this->product;
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function getVariantsAttribute()
    {
        return ProductVariant::where('variant_id', $this->id)->get();
    }

    public function productSize(): BelongsTo
    {
        return $this->belongsTo(ProductSize::class)->withDefault(
            [
                'name' => 'Medium',
                'slug' => 'M',
            ]
        );
    }
}
