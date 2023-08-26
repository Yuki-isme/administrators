<?php

namespace App\Services;

use App\Repositories\RoleRepository;
use App\Repositories\AdminRepository;
use App\Repositories\PermissionRepository;
use Illuminate\Support\Facades\DB;
use App\Exceptions\CommonException;

class AdminService
{
    private $adminRepository;

    public function __construct(AdminRepository $adminRepository)
    {
        $this->adminRepository = $adminRepository;
    }

    public function index()
    {
        return $this->adminRepository->index();
    }

    public function getPermissions()
    {

    }

    public function getAdmins()
    {

    }

    public function store($request)
    {
        try
        {
            DB::beginTransaction();
            $role = $this->adminRepository->create([
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
        return $this->adminRepository;
    }

    public function update($request, $id)
    {
        try
        {
            DB::beginTransaction();
            $role = $this->adminRepository->update($id,[
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

            // $role = $this->adminRepository;

            // $role->permissions()->detach();

            // $role->admins()->detach();

            // $role->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            throw new CommonException($e->getMessage());
        }
    }

}
