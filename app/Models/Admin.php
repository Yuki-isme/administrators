<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Traits\HasPermissions;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Admin extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasPermissions;

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // public function roles()
    // {
    //     return $this->belongsToMany(Role::class, 'admin_role', 'admin_id', 'role_id');
    // }

    public function avatar() : MorphOne
    {
        return $this->morphOne(Media::class, 'mediable')->where('type', 'avatar');
    }

}
