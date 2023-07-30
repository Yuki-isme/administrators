<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;

    protected $fillable =[
        'title',
        'url',
        'type',
        'mediable_id',
        'mediable_type'
    ];

    public function mediable(){
        return $this->morphTo();
    }
}
