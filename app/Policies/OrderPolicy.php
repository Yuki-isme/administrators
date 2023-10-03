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
    public function viewAny(): bool
    {
        return $this->admin->hasPermission('viewAny_order') || $this->admin->hasRole('Master');
    }

    public function viewAnyProcessing(): bool
    {
        return $this->admin->hasPermission('viewAnyProcessing_order') || $this->admin->hasRole('Master');
    }

    public function viewAnyCompleted(): bool
    {
        return $this->admin->hasPermission('viewAnyCompleted_order') || $this->admin->hasRole('Master');
    }

    public function viewAnyRequestCancel(): bool
    {
        return $this->admin->hasPermission('viewAnyRequestCancel_order') || $this->admin->hasRole('Master');
    }

    public function viewAnyCanceled(): bool
    {
        return $this->admin->hasPermission('viewAnyCanceled_order') || $this->admin->hasRole('Master');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(): bool
    {
        return $this->admin->hasPermission('view_order') || $this->admin->hasRole('Master');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(): bool
    {
        return $this->admin->hasPermission('create_order') || $this->admin->hasRole('Master');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(): bool
    {
        return $this->admin->hasPermission('update_order') || $this->admin->hasRole('Master');
    }

    public function cancel(): bool
    {
        return $this->admin->hasPermission('cancel_order') || $this->admin->hasRole('Master');
    }

    public function notCancel(): bool
    {
        return $this->admin->hasPermission('notCancel_order') || $this->admin->hasRole('Master');
    }

    public function initialization(): bool
    {
        return $this->admin->hasPermission('initialization') || $this->admin->hasRole('Master');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(): bool
    {
        return $this->admin->hasPermission('delete_order') || $this->admin->hasRole('Master');
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
