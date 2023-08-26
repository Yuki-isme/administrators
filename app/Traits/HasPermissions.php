<?php

namespace App\Traits;

use App\Models\Role;

trait HasPermissions
{
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function hasRole($role)
    {
        if (is_string($role)) {
            return $this->roles->contains('name', $role);
        }

        return false;
    }

    public function allPermissions()
    {
        return $this->roles->flatMap->permissions->pluck('name')->unique();
    }

    public function hasPermission($permission)
    {
        return $this->hasAnyPermission($permission);
    }

    public function hasAnyPermission(...$permissions)
    {
        foreach ($permissions as $permission) {
            if ($this->roles->flatMap->permissions->contains('name', $permission)) {
                return true;
            }
        }

        return false;
    }
}
