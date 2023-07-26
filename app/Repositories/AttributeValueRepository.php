<?php

namespace App\Repositories;

use App\Models\AttributeValue;


class AttributeValueRepository extends BaseRepository
{

    private $model;

    public function __construct(AttributeValue $model)
    {
        $this->model = $model;
        parent::__construct($model);
    }

}
