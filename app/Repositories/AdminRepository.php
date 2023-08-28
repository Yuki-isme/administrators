<?php

namespace App\Repositories;

use App\Models\Admin;

use Illuminate\Support\Facades\Auth;


class AdminRepository extends BaseRepository
{

    private $model;

    public function __construct(Admin $model)
    {
        $this->model = $model;
        parent::__construct($model);
    }

    public function getAdmin()
    {
        return Auth::guard('admin')->user();
    }

    public function getAdmins()
    {
        return $this->model->get();
    }

    public function index()
    {
        return $this->model->with('roles.permissions')->get();
    }

    public function getAdminRoles($id)
    {
        return $this->model->with('roles')->find($id);
    }
}
