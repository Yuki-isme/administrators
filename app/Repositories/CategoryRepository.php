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
        return $this->model->with('thumbnail', 'child.child.child')->where('parent_id', 0)->get(); //lấy tất cả category có parent_id = 0 kèm con
    }

    public function getCategories()
    {
        return $this->model->with('parent.parent.parent.parent')->get();
    }

    public function getAllSub()
    {
        return $this->model->with('parent')->where('parent_id', '!=', 0)->get(); //lấy tất cả category có parent_id != 0 kèm cha
    }

    public function getCategoryById($id)
    {
        return $this->model->with('products', 'thumbnail')->find($id);
    }

    public function getChildrenByParent_id($id)
    {
        return $this->model->where('parent_id', $id)->get(); //lấy tất cả con của 1 cha
    }

    public function getParentById($id)
    {
        return $this->model->where('id', $id)->whereHas('child', function ($query) {
            $query->where('is_active', 1);
        })->exists(); //trả về true nếu category này có category con có is active = 1
    }

    public function getListCategories()
    {
        return $this->model->get();
    }

    public function getCategoriesIndex()
    {
        return $this->model->with('thumbnail')->where('parent_id', 0)
        ->orWhereIn('parent_id', function ($query) {
            $query->select('id')
                ->from('categories')
                ->where('parent_id', 0);
        })
        ->orderBy('id', 'asc')
        ->limit(16)
        ->get();
    }
}
