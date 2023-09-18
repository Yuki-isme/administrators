<?php

namespace App\Policies;

use App\Models\Brand;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\Response;

class BrandPolicy
{
    private $admin;

    function __construct (){
        $this->admin = Admin::find(Auth::guard('admin')->user()->id);
    }
    /**
     * Determine whether the admin can view any models.
     */
    public function viewAny(?Admin $admin): bool
    {
        return $this->admin->hasPermission('viewAny_brand') || $this->admin->hasRole('Master');
    }

    /**
     * Determine whether the admin can view the model.
     */
    public function view(Admin $admin): bool
    {

        return 0;
    }

    /**
     * Determine whether the admin can create models.
     */
    public function create(?Admin $admin): bool
    {
        return $this->admin->hasPermission('create_brand') || $this->admin->hasRole('Master');
    }

    /**
     * Determine whether the admin can update the model.
     */
    public function update(?Admin $admin): bool
    {
        return $this->admin->hasPermission('update_brand') || $this->admin->hasRole('Master');
    }

    /**
     * Determine whether the admin can delete the model.
     */
    public function delete(?Admin $admin): bool
    {
        return $this->admin->hasPermission('delete_brand') || $this->admin->hasRole('Master');
    }

    /**
     * Determine whether the admin can restore the model.
     */
    public function restore(Admin $admin): bool
    {
        return 0;
    }

    /**
     * Determine whether the admin can permanently delete the model.
     */
    public function forceDelete(Admin $admin): bool
    {
        return 0;
    }
}
