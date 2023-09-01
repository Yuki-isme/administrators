<?php

namespace App\Repositories;

use App\Models\Ward;



class WardRepository extends BaseRepository
{

    private $model;

    public function __construct(Ward $model)
    {
        $this->model = $model;
        parent::__construct($model);
    }

    public function query()
    {
        return $this->model->query();
    }

}
