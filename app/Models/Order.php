<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone_number',
        'email',
        'payment_method',
        'payment_status',
        'province_code',
        'district_code',
        'ward_code',
        'street',
        'house',
        'note',
        'note_order',
        'total',
        'discount',
        'status_id',
        'user_id',
    ];

    public function items()
    {
        return $this->hasMany(Item::class, 'order_id', 'id');
    }

    public function province()
    {
        return $this->belongsTo(Province::class, 'province_code', 'code');
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'district_code', 'code');
    }

    public function ward()
    {
        return $this->belongsTo(Ward::class, 'ward_code', 'code');
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }
}
