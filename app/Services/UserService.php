<?php

namespace App\Services;

use App\Repositories\RoleRepository;
use App\Repositories\UserRepository;
use App\Repositories\MediaRepository;
use Illuminate\Support\Facades\DB;
use App\Exceptions\CommonException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

use App\Models\User;

class UserService
{
    private $userRepository;
    private $roleRepository;
    private $mediaRepository;

    public function __construct(UserRepository $userRepository, RoleRepository $roleRepository, MediaRepository $mediaRepository)
    {
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
        $this->mediaRepository = $mediaRepository;
    }

    public function index()
    {
        return $this->userRepository->index();
    }

    public function store($request)
    {
        try
        {
            DB::beginTransaction();
            
            $this->userRepository->create([
                'name' => $request->name,
                'username' => $request->username,
                'phone' => $request->phone,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            DB::commit();
        }
        catch(\Exception $e)
        {
            DB::rollBack();

            throw new CommonException($e->getMessage());
        }
    }


    public function update($request, $id)
    {
        try
        {
            DB::beginTransaction();
            

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

            $user = $this->userRepository->getUserInfo($id);

            $user->info->delete();

            $user->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            throw new CommonException($e->getMessage());
        }
    }

}
