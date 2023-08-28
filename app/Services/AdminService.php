<?php

namespace App\Services;

use App\Repositories\RoleRepository;
use App\Repositories\AdminRepository;
use App\Repositories\MediaRepository;
use Illuminate\Support\Facades\DB;
use App\Exceptions\CommonException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

use App\Models\Admin;

class AdminService
{
    private $adminRepository;
    private $roleRepository;
    private $mediaRepository;

    public function __construct(AdminRepository $adminRepository, RoleRepository $roleRepository, MediaRepository $mediaRepository)
    {
        $this->adminRepository = $adminRepository;
        $this->roleRepository = $roleRepository;
        $this->mediaRepository = $mediaRepository;
    }

    public function index()
    {
        return $this->adminRepository->index();
    }

    public function getRoles()
    {
        return $this->roleRepository->getRolesAdmin();
    }

    public function store($request)
    {
        try
        {
            DB::beginTransaction();
            $admin = $this->adminRepository->create([
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $admin->roles()->sync($request->roles);

            if ($request->hasFile('avatar')) {
                $avatar = $request->file('avatar');
                $imageName = Carbon::now()->format('Y-m-d-H-i-s') . '-' . $avatar->getClientOriginalName();
                $url =  $avatar->storeAs('avatars', $imageName, 'public');

                $this->mediaRepository->create([
                    'title' => $imageName,
                    'url' => $url,
                    'type' => 'thumbnail',
                    'mediable_type' => Admin::class,
                    'mediable_id' => $admin->id,
                ]);
            }

            DB::commit();
        }
        catch(\Exception $e)
        {
            DB::rollBack();

            throw new CommonException($e->getMessage());
        }
    }

    public function getAdminRoles($id)
    {
        return $this->adminRepository->getAdminRoles($id);
    }

    public function update($request, $id)
    {
        try
        {
            DB::beginTransaction();
            $admin = $this->adminRepository->update($id,[
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
            ]);

            if ($request->has('password')) {
                $admin['password'] = Hash::make($request->password);
            }

            $role = $request->roles ?? [];

            $admin->roles()->sync($role);

            if ($request->hasFile('avatar')) {
                if ($admin->avatar) {
                    Storage::disk('public')->delete($admin->avatar->url);
                }
                $avatar = $request->file('avatar');
                $imageName = Carbon::now()->format('Y-m-d-H-i-s') . '-' . $avatar->getClientOriginalName();
                $url =  $avatar->storeAs('avatars', $imageName, 'public');

                $this->mediaRepository->create([
                    'title' => $imageName,
                    'url' => $url,
                    'type' => 'avatar',
                    'mediable_type' => Admin::class,
                    'mediable_id' => $admin->id,
                ]);
            }

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

            $admin = $this->adminRepository->getAdminRoles($id);

            $admin->roles()->detach();

            $admin->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            throw new CommonException($e->getMessage());
        }
    }

}
