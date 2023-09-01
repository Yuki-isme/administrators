<?php

namespace App\Repositories;

use App\Models\Province;



class ProvinceRepository extends BaseRepository
{

    private $model;

    public function __construct(Province $model)
    {
        $this->model = $model;
        parent::__construct($model);
    }

    public function getProvinces()
    {
        return $this->model->get();
    }

}
