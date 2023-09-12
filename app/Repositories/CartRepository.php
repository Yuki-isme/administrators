<?php

namespace App\Repositories;

use App\Models\Cart;



class CartRepository extends BaseRepository
{

    private $model;

    public function __construct(Cart $model)
    {
        $this->model = $model;
        parent::__construct($model);
    }

    

}
