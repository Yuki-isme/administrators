<?php

namespace App\Repositories;

use App\Models\Order;



class OrderRepository extends BaseRepository
{

    private $model;

    public function __construct(Order $model)
    {
        $this->model = $model;
        parent::__construct($model);
    }

}
