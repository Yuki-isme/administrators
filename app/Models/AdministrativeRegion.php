<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdministrativeRegion extends Model
{
    use HasFactory;

    protected $table = 'administrative_region';

    public function provinces()
    {
        return $this->hasMany(Province::class);
    }

    public function administrativeUnits()
    {
        return $this->hasMany(AdministrativeUnit::class);
    }
}
