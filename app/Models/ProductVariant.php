<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductVariant extends Model
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
        'quantity'
    ];

    protected $appends = [ 'variants'];

    public function getParentAttribute() : Model
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
}
