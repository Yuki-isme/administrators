<?php

namespace App\Repositories;

use App\Models\Item;



class ItemRepository extends BaseRepository
{

    private $model;

    public function __construct(Item $model)
    {
        $this->model = $model;
        parent::__construct($model);
    }

}
