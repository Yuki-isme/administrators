<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\Response;

class ProductPolicy
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
        return $this->admin->hasPermission('index_product');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?Admin $admin, Product $product): bool
    {
        return $this->admin->hasPermission('detail_product');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(?Admin $admin): bool
    {
        return $this->admin->hasPermission('create_roduct');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(?Admin $admin, Product $product): bool
    {
        return $this->admin->hasPermission('update_product');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(?Admin $admin, Product $product): bool
    {
        return $this->admin->hasPermission('delete_product');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(?Admin $admin, Product $product): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(?Admin $admin, Product $product): bool
    {
        //
    }
}
