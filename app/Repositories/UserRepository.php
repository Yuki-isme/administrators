<?php

namespace App\Repositories;

use App\Models\User;

use Illuminate\Support\Facades\Auth;


class UserRepository extends BaseRepository
{

    private $model;

    public function __construct(User $model)
    {
        $this->model = $model;
        parent::__construct($model);
    }

    public function getUser()
    {
        return Auth::guard('web')->user();
    }

    public function getInfoUser()
    {
        $user = $this->getUser();

        if ($user) {
            return $user->load('info.district', 'info.ward');
        }

        return null;
    }

    public function index()
    {
        return $this->model->with('info.province','info.district', 'info.ward')->get();
    }

    public function getUserInfo($id){
        return $this->model->with('info')->find($id);
    }
}
