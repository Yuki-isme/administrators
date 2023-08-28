<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permission')->orderBy('role_id')->orderBy('permission_id');
    }

    public function admins()
    {
        return $this->belongsToMany(Admin::class);
    }
}
