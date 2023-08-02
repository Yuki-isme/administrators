<?php

namespace App\Repositories;

use App\Models\Media;



class MediaRepository extends BaseRepository
{

    private $model;

    public function __construct(Media $model)
    {
        $this->model = $model;
        parent::__construct($model);
    }

}
