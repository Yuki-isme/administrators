<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'sale_price',
        'stock',
        'sku',
        'slug',
        'is_active',
        'is_hot',
        'is_feature',
        'description',
        'content',
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

    public function media() : MorphMany
    {
        return $this->morphMany(Media::class, 'mediable');
    }
}
