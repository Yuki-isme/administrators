<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'sku',
        'stock',
        'price',
        'sale_price',
        'content',
        'description',
        'is_active',
        'is_hot',
        'is_feature',
        'brand_id',
        'category_id'
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function category() : BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function attributeValue()
    {
        return $this->hasMany(AttributeValue::class);
    }

    public function thumbnail() : MorphOne
    {
        return $this->morphOne(Media::class, 'mediable')->where('type', 'thumbnail');
    }

    public function media() : MorphMany
    {
        return $this->morphMany(Media::class, 'mediable')->where('type', 'catalog');
    }

    public function getCartPriceAttribute()
    {
        if($this->sale_price){
            return $this->sale_price;
        }

        return $this->price;
    }
}
