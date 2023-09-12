<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class AdminPolicy
{
    private $admin;
    function __construct (){
        $this->admin = Auth::guard('admin')->user();
    }
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(?Admin $admin): bool
    {
        return $this->admin->hasPermission('viewAny_admin') || $this->admin->hasRole('Master');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?Admin $admin, Admin $a): bool
    {
        return $this->admin->hasPermission('detail_admin') || $this->admin->hasRole('Master');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(?Admin $admin): bool
    {
        return $this->admin->hasPermission('create_admin') || $this->admin->hasRole('Master');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(?Admin $admin, Admin $a): bool
    {
        return $this->admin->hasPermission('update_admin') || $this->admin->hasRole('Master');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(?Admin $admin, Admin $a): bool
    {
        return $this->admin->hasPermission('delate_admin') || $this->admin->hasRole('Master');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(?Admin $admin, Admin $a): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(?Admin $admin, Admin $a): bool
    {
        //
    }
}
