<?php

namespace App\Repositories;

use App\Models\Attribute;


class AttributeRepository extends BaseRepository
{

    private $model;

    public function __construct(Attribute $model)
    {
        $this->model = $model;
        parent::__construct($model);
    }

    public function findByName($name)
    {
        return $this->model->where('name', $name)->first();
    }
}
