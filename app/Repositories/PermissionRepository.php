<?php

namespace App\Repositories;

use App\Models\Permission;



class PermissionRepository extends BaseRepository
{

    private $model;

    public function __construct(Permission $model)
    {
        $this->model = $model;
        parent::__construct($model);
    }

    public function getPermissions()
    {
        return $this->model->get();
    }

    public function index()
    {
        return $this->model->with('roles')->get();
    }
}
