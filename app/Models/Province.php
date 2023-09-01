<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use HasFactory;

    public function administrativeRegion()
    {
        return $this->belongsTo(AdministrativeRegion::class);
    }

    public function administrativeUnit()
    {
        return $this->belongsTo(AdministrativeUnit::class);
    }

    public function districts()
    {
        return $this->hasMany(District::class, 'province_code', 'code');
    }
}
