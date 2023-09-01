<?php

namespace App\Repositories;

use App\Models\District;



class DistrictRepository extends BaseRepository
{

    private $model;

    public function __construct(District $model)
    {
        $this->model = $model;
        parent::__construct($model);
    }

    public function getDistricts($id)
    {
        return $this->model->where('province_code',$id)->get();//lấy tất cả con của 1 cha
    }
}
