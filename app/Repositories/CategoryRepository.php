<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

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

        $category->name = $data['name'];
        $category->slug = $data['slug'];
        $category->description = $data['description'];
        $category->parent_id = $data['parent_id'] ?? 0;
        $category->is_active = $data['is_active'] ?? 1;

        $file = $data['img'];
        $extension = $file->getClientOriginalExtension();
        $fileName = uniqid(Str::slug($data['name']) . '-') . '.' . $extension;
        $file->move('admin/assets/img/category', $fileName);

        $category->path_img = $fileName;

        $category->save();

        return ['success' => 'Category created successfully'];
    }

    public function update($categoryId, $data)
    {

        $category = Category::find($categoryId);

        $category->name = $data['name'];
        $category->slug = $data['slug'];
        $category->description = $data['description'];
        $category->parent_id = $data['parent_id'] ?? 0;
        $category->is_active = $data['is_active'] ?? 1;


        if (isset($data['img']) && $data['img']->isValid()) {
            $file = $data['img'];
            $extension = $file->getClientOriginalExtension();
            $fileName = uniqid(Str::slug($data['name'])) . '.' . $extension;
            $file->move('admin/assets/img/category', $fileName);

            if ($category->path_img) {
                Storage::delete('admin/assets/img/category/' . $category->path_img);
            }
            $category->path_img = $fileName;
        }

        $category->save();

        return $category;
    }

    public function delete($id)
    {
        return Category::destroy($id);
    }
}
