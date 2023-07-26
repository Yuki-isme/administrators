<?php

namespace App\Repositories;

use App\Models\Brand;



class BrandRepository extends BaseRepository
{

    private $model;

    public function __construct(Brand $model)
    {
        $this->model = $model;
        parent::__construct($model);
    }

    public function getAllBrands()
    {
        return $this->model->get(); //lấy tất cả
    }

}
