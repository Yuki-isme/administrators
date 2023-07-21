<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

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
        return $this->model->where('parent_id', 0)->get();
    }

    public function store($data)
    {

        $category = new Category();

        $file = $data['img'];
        $extension = $file->getClientOriginalExtension();
        $fileName = uniqid(Str::slug($data['name']) . '-') . '.' . $extension;
        $file->move('admin/assets/img/category', $fileName);

        $category->name = $data['name'];
        $category->slug = $data['slug'];
        $category->description = $data['description'];
        $category->parent_id = $data['parent_id'] ?? 0;
        $category->is_active = $data['is_active'] ?? 1;
        $category->path_img = $fileName;

        $category->save();

        return ['success' => 'Category created successfully'];
    }

    public function update($Id, $data)
    {
        $category = Category::find($Id);

        if (isset($data['img']) && $data['img'] instanceof \Illuminate\Http\UploadedFile) {
            $file = $data['img'];
            $extension = $file->getClientOriginalExtension();
            $fileName = uniqid(Str::slug($data['name']).'-') . '.' . $extension;
            $file->move('admin/assets/img/category', $fileName);

            File::delete('admin/assets/img/category/' . $category->path_img);
        } else {
            $fileName = uniqid(Str::slug($data['name']).'-') . '.' . pathinfo($category->path_img, PATHINFO_EXTENSION);
            
            File::move('admin/assets/img/category/' . $category->path_img, 'admin/assets/img/category/' . $fileName);
        }

        $category->name = $data['name'];
        $category->slug = $data['slug'];
        $category->description = $data['description'];
        $category->parent_id = $data['parent_id'] ?? 0;
        $category->is_active = $data['is_active'] ?? 1;
        $category->path_img = $fileName;

        $category->save();

        return $category;
    }

    public function delete($id)
    {
        $category = Category::where('parent_id', $id)->exists();

        if ($category) {
            return ['error' => 'Không thể xóa category cha'];
        }

        File::delete('admin/assets/img/category/' . $category->path_img);
        Category::destroy($id);

        return  ['success' => 'Xóa thành công!'];
    }

    public function getChildCategories()
    {
        $child_categories = Category::with('parent')->where('parent_id', '!=', 0)->get();

        return $child_categories;
    }
}
