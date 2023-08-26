<?php

namespace App\Repositories;

use App\Models\Tag;



class TagRepository extends BaseRepository
{

    private $model;

    public function __construct(Tag $model)
    {
        $this->model = $model;
        parent::__construct($model);
    }

    public function index()
    {
        return $this->model->get();
    }

}
