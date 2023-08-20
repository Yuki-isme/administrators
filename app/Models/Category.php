<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\Morphone;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'parent_id',
        'is_active',
    ];

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id')->withDefault(['name' => 'No Parent']);
    }

    public function thumbnail() : MorphOne
    {
        return $this->morphOne(Media::class, 'mediable')->where('type', 'thumbnail');
    }

    // public function subcategories()
    // {
    //     return $this->hasMany(Category::class, 'parent_id');
    // }
}
