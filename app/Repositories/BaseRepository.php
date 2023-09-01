<?php

namespace App\Repositories;

use App\Models;

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

        $model->update($attribute);

        return $model;
    }

    public function delete($id)
    {
        return $this->model->find($id)->delete();
    }

    public function getModel($name){
        return $name::class;
    }

    public function query()
    {
        return $this->model->query();
    }
}
