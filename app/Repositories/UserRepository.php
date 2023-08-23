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

    public function getInforUser()
    {
        return $this->getUser()->infor;
    }
}
