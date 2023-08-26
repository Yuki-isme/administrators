<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'status'
    ];

    public function orderItems()
    {
        return $this->hasMany(Item::class, 'order_id', 'id');
    }
}
