<?php

namespace App\Repositories;

use App\Models\Category;



class CategoryRepository extends BaseRepository
{

    private $model;

    public function __construct(Category $model)
    {
        $this->model = $model;
        parent::__construct($model);
    }

    public function getAllCategories()
    {
        return $this->model->where('parent_id', 0)->get(); //lấy tất cả category có parent_id = 0
    }

    public function getParentById($id){
        return $this->model->where('parent_id', $id)->exists(); //lấy category có parent_id = $id
    }

    public function getAllSub()
    {
        return $this->model->with('parent')->where('parent_id', '!=', 0)->get(); //lấy tất cả category có parent_id != 0
    }

    public function getChildrenByParent_id($id)
    {
        return $this->model->where('parent_id',$id)->get();
    }
}
