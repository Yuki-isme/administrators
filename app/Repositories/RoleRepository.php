<?php

namespace App\Repositories;

use App\Models\Role;



class RoleRepository extends BaseRepository
{

    private $model;

    public function __construct(Role $model)
    {
        $this->model = $model;
        parent::__construct($model);
    }

    public function index()
    {
        return $this->model->with('permissions', 'admins')->get();
    }

    public function getRoleById($id)
    {
        return $this->model->with('permissions', 'admins')->find($id);
    }
}
