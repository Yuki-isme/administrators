<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'stock',
        'sku',
        'slug',
        'is_active',
        'feature',
        'description',
        'content',
        'images',
        'brand_id',
        'category_id'
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function attributeValue()
    {
        return $this->hasMany(AttributeValue::class);
    }
}
