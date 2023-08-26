<?php

namespace App\Services;

use App\Repositories\PermissionRepository;

class PermissionService
{
    private $permissionRepository;

    public function __construct(PermissionRepository $permissionRepository)
    {
        $this->permissionRepository = $permissionRepository;
    }

    public function index()
    {
        return $this->permissionRepository->index();
    }

}
