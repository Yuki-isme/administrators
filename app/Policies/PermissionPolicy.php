<?php

namespace App\Policies;

use App\Models\Permission;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\Response;

class PermissionPolicy
{
    private $admin;
    function __construct (){
        $this->admin = Admin::find(Auth::guard('admin')->user()->id);
    }
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(): bool
    {
        return $this->admin->hasPermission('viewAny_permission') || $this->admin->hasRole('Master');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(): bool
    {
        return $this->admin->hasPermission('detail_permission') || $this->admin->hasRole('Master');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(): bool
    {
        return $this->admin->hasPermission('create_permission') || $this->admin->hasRole('Master');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(): bool
    {
        return $this->admin->hasPermission('update_permission') || $this->admin->hasRole('Master');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(): bool
    {
        return $this->admin->hasPermission('delete_permission') || $this->admin->hasRole('Master');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(): bool
    {
        return 0;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(): bool
    {
        return 0;
    }
}
