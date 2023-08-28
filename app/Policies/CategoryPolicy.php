<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\Response;

class CategoryPolicy
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
        return $this->admin->hasPermission('index_category');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?Admin $admin, Category $category): bool
    {
        return $this->admin->hasPermission('detail_category');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(?Admin $admin): bool
    {
        return $this->admin->hasPermission('create_category');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(?Admin $admin, Category $category): bool
    {
        return $this->admin->hasPermission('update_category');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(?Admin $admin, Category $category): bool
    {
        return $this->admin->hasPermission('delete_category');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(?Admin $admin, Category $category): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(?Admin $admin, Category $category): bool
    {
        //
    }
}
