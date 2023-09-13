<?php

namespace App\Repositories;

use App\Models\Status;



class StatusRepository extends BaseRepository
{

    private $model;

    public function __construct(Status $model)
    {
        $this->model = $model;
        parent::__construct($model);
    }

}
