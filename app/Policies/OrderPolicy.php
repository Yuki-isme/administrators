<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\Response;

class OrderPolicy
{
    private $admin;
    function __construct (){
        $this->admin = Admin::find(Auth::guard('admin')->user()->id);
    }
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(?Admin $admin): bool
    {
        return $this->admin->hasPermission('viewAny_order') || $this->admin->hasRole('Master');
    }

    public function viewAnyProcessing(?Admin $admin): bool
    {
        return $this->admin->hasPermission('viewAnyProcessing_order') || $this->admin->hasRole('Master');
    }

    public function viewAnyCompleted(?Admin $admin): bool
    {
        return $this->admin->hasPermission('viewAnyCompleted_order') || $this->admin->hasRole('Master');
    }

    public function viewAnyRequestCancel(?Admin $admin): bool
    {
        return $this->admin->hasPermission('viewAnyRequestCancel_order') || $this->admin->hasRole('Master');
    }

    public function viewAnyCanceled(?Admin $admin): bool
    {
        return $this->admin->hasPermission('viewAnyCanceled_order') || $this->admin->hasRole('Master');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?Admin $admin): bool
    {
        return $this->admin->hasPermission('view_order') || $this->admin->hasRole('Master');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(?Admin $admin): bool
    {
        return $this->admin->hasPermission('create_order') || $this->admin->hasRole('Master');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(?Admin $admin): bool
    {
        return $this->admin->hasPermission('update_order') || $this->admin->hasRole('Master');
    }

    public function cancel(?Admin $admin): bool
    {
        return $this->admin->hasPermission('cancel_order') || $this->admin->hasRole('Master');
    }

    public function notCancel(?Admin $admin): bool
    {
        return $this->admin->hasPermission('notCancel_order') || $this->admin->hasRole('Master');
    }

    public function initialization(?Admin $admin): bool
    {
        return $this->admin->hasPermission('initialization') || $this->admin->hasRole('Master');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(?Admin $admin): bool
    {
        return $this->admin->hasPermission('delete_order') || $this->admin->hasRole('Master');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(?Admin $admin): bool
    {
        return 0;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(?Admin $admin): bool
    {
        return 0;
    }
}