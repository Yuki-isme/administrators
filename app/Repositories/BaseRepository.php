<?php

namespace App\Repositories;

class BaseRepository
{
    private $model;

    public function __construct($model){
        $this->model = $model;
    }

    public function getById($id){
        return $this->model->find($id);
    }

    public function create($attribute = [])
    {
        return $this->model->firstOrCreate($attribute);
    }

    public function update($id, $attribute)
    {
        $model = $this->getById($id);

        return $model->update($attribute);
    }

}
