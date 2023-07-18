<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Support\Str;

class CategoryRepository extends BaseRepository
{

    private $model;

    public function __construct(Category $model)
    {
        $this->model = $model;
        parent::__construct($model);
    }

    public function getCategories()
    {
        return $this->model->paginate(10);
    }

    public function store($data)
    {

        $category = new Category();

        // Set the category attributes
        $category->name = $data['name'];
        $category->slug = $data['slug'];
        $category->description = $data['description'];
        $category->parent_id = $data['parent_id'] ?? 0;
        $category->is_active = $data['is_active'] ?? 1;

        // Save the image to public/assets/img/category
        $file = $data['img'];
        $extension = $file->getClientOriginalExtension();
        $fileName = uniqid(Str::slug($data['name']) . '-') . '.' . $extension;
        $file->move('admin/assets/img/category', $fileName);

        // Save the image file name to the category's path_img field
        $category->path_img = $fileName;

        // Save the category to the database
        $category->save();

        return ['success' => 'Category created successfully'];
    }

    public function getCategoryById($id)
    {
        return $this->model->find($id);
    }


    public function delete($id)
    {
        // Xóa danh mục dựa trên ID
        return Category::destroy($id);
    }
}
