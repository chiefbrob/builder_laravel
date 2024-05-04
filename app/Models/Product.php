<?php

namespace App\Models;

use App\Casts\MoneyCast;
use App\Models\Shop\Variants;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Variants
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'slug',
        'price',
        'description',
        'photo',
        'long_description',
        'featured'
    ];

    protected $casts = [
        'price' => MoneyCast::class,
        'featured' => 'boolean'
    ];

    protected $with = ['productVariants'];

    public function productVariants(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function productCategories(): HasMany
    {
        return $this->hasMany(ProductCategory::class);
    }
}
