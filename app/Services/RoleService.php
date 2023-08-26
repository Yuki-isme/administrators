<?php

namespace App\Services;

use App\Repositories\RoleRepository;
use App\Repositories\AdminRepository;
use App\Repositories\PermissionRepository;
use Illuminate\Support\Facades\DB;
use App\Exceptions\CommonException;

class RoleService
{
    private $roleRepository;
    private $adminRepository;
    private $permissionRepository;

    public function __construct(RoleRepository $roleRepository, PermissionRepository $permissionRepository, AdminRepository $adminRepository)
    {
        $this->roleRepository = $roleRepository;
        $this->permissionRepository = $permissionRepository;
        $this->adminRepository = $adminRepository;
    }

    public function index()
    {
        return $this->roleRepository->index();
    }

    public function getPermissions()
    {
        return $this->permissionRepository->getPermissions();
    }

    public function getAdmins()
    {
        return $this->adminRepository->getAdmins();
    }

    public function store($request)
    {
        try
        {
            DB::beginTransaction();
            $role = $this->roleRepository->create([
                'name' => $request->name,
            ]);

            $role->permissions()->sync($request->permissions);

            $role->admins()->sync($request->admins);

            DB::commit();
        }
        catch(\Exception $e)
        {
            DB::rollBack();

            throw new CommonException($e->getMessage());
        }
    }

    public function getRoleById($id)
    {
        return $this->roleRepository->getRoleById($id);
    }

    public function update($request, $id)
    {
        try
        {
            DB::beginTransaction();
            $role = $this->roleRepository->update($id,[
                'name' => $request->name,
            ]);

            $role->permissions()->sync($request->permissions);

            $role->admins()->sync($request->admins);

            DB::commit();
        }
        catch(\Exception $e)
        {
            DB::rollBack();

            throw new CommonException($e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {

            DB::beginTransaction();

            $role = $this->roleRepository->getRoleById($id);

            $role->permissions()->detach();

            $role->admins()->detach();

            $role->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            throw new CommonException($e->getMessage());
        }
    }

}
