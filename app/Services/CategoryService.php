<?php

namespace App\Services;

use App\Repositories\CategoryRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class CategoryService
{
    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function getAllCategory()
    {
        return $this->categoryRepository->getAllCategories(); //lấy tất cả category có parent_id = 0
    }

    public function store($request)
    {
        try {
            if (isset($request->img) && $request->img->isValid()) {
                DB::beginTransaction();

                $file = $request->img;
                $extension = $file->getClientOriginalExtension();
                $fileName = uniqid(Str::slug($request->name) . '-') . '.' . $extension;
                $file->move('admin/assets/img/category', $fileName);

                $this->categoryRepository->create([
                    'name' => $request->name,
                    'slug' => $request->slug,
                    'description' => $request->description,
                    'parent_id' => $request->parent_id ?? 0,
                    'is_active' => $request->is_active ?? 0,
                    'path_img' => $fileName,
                ]);

                DB::commit();

                return isset($request->parent_id) ?  Redirect::route('categories.sub_index')->with('success', 'Created sub category successfully!') :  Redirect::route('categories.index')->with('success', 'Created category successfully!');
            } else {
                throw new \Exception('Invalid image or no image uploaded');
            }
        } catch (\Exception $e) {
            DB::rollBack();

            return Redirect::back()->withErrors(['errors' => $e->getMessage()])->withInput();
        }
    }


    public function getCategoryById($id)
    {
        return $this->categoryRepository->getById($id);//lấy để chỉnh sửa dùng chung
    }

    public function update($id, $request)
    {
        try {
            $category = $this->categoryRepository->getById($id);

            if (!$category) {
                throw new \Exception('Category not found!');
            }

            if ($this->categoryRepository->getParentById($id) && is_null($request->is_active)) { //nếu là parent thì không thể turn off is_active
                throw new \Exception('Unable to disable active parent category containing subcategories');
            }

            DB::beginTransaction();

            if (isset($request->img) && $request->img->isValid()) {
                $file = $request->img;
                $extension = $file->getClientOriginalExtension();
                $fileName = uniqid(Str::slug($request->name) . '-') . '.' . $extension;
                $file->move('admin/assets/img/category', $fileName);

                File::delete('admin/assets/img/category/' . $category->path_img);
            } else {

                $fileName = uniqid(Str::slug($request['name']) . '-') . '.' . pathinfo($category->path_img, PATHINFO_EXTENSION);

                File::move('admin/assets/img/category/' . $category->path_img, 'admin/assets/img/category/' . $fileName);
            }

            $category->update([
                'name' => $request->name,
                'slug' => $request->slug,
                'description' => $request->description,
                'parent_id' => $request->parent_id ?? 0,
                'is_active' => $request->is_active ?? 0,
                'path_img' => $fileName,
            ]);

            DB::commit();

            return isset($request->parent_id) ?  Redirect::route('categories.sub_index')->with('success', 'Updated sub category successfully!') :  Redirect::route('categories.index')->with('success', 'Updated category successfully!');
        } catch (\Exception $e) {
            DB::rollBack();

            return Redirect::back()->withErrors(['errors' => $e->getMessage()])->withInput();
        }
    }


    public function destroy($id)
    {
        try {
            if ($this->categoryRepository->getParentById($id)) {
                throw new \Exception('Cannot delete parent category containing subcategories');
            }

            DB::beginTransaction();

            $category = $this->categoryRepository->getById($id);

            if (!$category) {
                throw new \Exception('Category not found');
            }

            // Delete the category image (if any)
            if ($category->path_img) {
                File::delete('admin/assets/img/category/' . $category->path_img);
            }

           $category->delete();

            DB::commit();

            return Redirect::back()->with('alert', 'Deleted category successfully!');
        } catch (\Exception $e) {
            DB::rollBack();

            return Redirect::back()->withErrors(['errors' => $e->getMessage()])->withInput();
        }
    }

    //sub
    public function getAllSub()
    {
        return $this->categoryRepository->getAllSub();
    }

    // public function subStore($request)
    // {
    //     try {
    //         if (isset($request->img) && $request->img->isValid()) {
    //             DB::beginTransaction();

    //             $file = $request->img;
    //             $extension = $file->getClientOriginalExtension();
    //             $fileName = uniqid(Str::slug($request->name) . '-') . '.' . $extension;
    //             $file->move('admin/assets/img/category', $fileName);

    //             $this->categoryRepository->create([
    //                 'name' => $request->name,
    //                 'slug' => $request->slug,
    //                 'description' => $request->description,
    //                 'parent_id' => $request->parent_id ?? 0,
    //                 'is_active' => $request->is_active ?? 0,
    //                 'path_img' => $fileName,
    //             ]);

    //             DB::commit();

    //             return Redirect::route('categories.sub-index')->with('success', 'Created category successfully!');
    //         } else {
    //             throw new \Exception('Invalid image or no image uploaded');
    //         }
    //     } catch (\Exception $e) {
    //         DB::rollBack();

    //         return Redirect::back()->withErrors(['errors' => $e->getMessage()])->withInput();
    //     }
    // }

    // public function subUpdate($id, $request)
    // {
    //     try {
    //         $category = $this->categoryRepository->getById($id);

    //         if (!$category) {
    //             throw new \Exception('Category not found!');
    //         }

    //         DB::beginTransaction();

    //         if (isset($request->img) && $request->img->isValid()) {
    //             $file = $request->img;
    //             $extension = $file->getClientOriginalExtension();
    //             $fileName = uniqid(Str::slug($request->name) . '-') . '.' . $extension;
    //             $file->move('admin/assets/img/category', $fileName);

    //             File::delete('admin/assets/img/category/' . $category->path_img);
    //         } else {

    //             $fileName = uniqid(Str::slug($request['name']) . '-') . '.' . pathinfo($category->path_img, PATHINFO_EXTENSION);

    //             File::move('admin/assets/img/category/' . $category->path_img, 'admin/assets/img/category/' . $fileName);
    //         }

    //         $category->update([
    //             'name' => $request->name,
    //             'slug' => $request->slug,
    //             'description' => $request->description,
    //             'parent_id' => $request->parent_id ?? 0,
    //             'is_active' => isset($request->is_active) ? 1: 0,
    //             'path_img' => $fileName,
    //         ]);

    //         DB::commit();

    //         return Redirect::route('categories.sub-index')->with('success', 'Updated category successfully!');
    //     } catch (\Exception $e) {
    //         DB::rollBack();

    //         return Redirect::back()->withErrors(['errors' => $e->getMessage()])->withInput();
    //     }
    // }


    // public function subDestroy($id)
    // {
    //     try {
    //         if ($this->categoryRepository->getParentById($id)) {
    //             throw new \Exception('Cannot delete parent category containing subcategories');
    //         }

    //         DB::beginTransaction();

    //         $category = $this->categoryRepository->getById($id);

    //         if (!$category) {
    //             throw new \Exception('Category not found');
    //         }

    //         // Delete the category image (if any)
    //         if ($category->path_img) {
    //             File::delete('admin/assets/img/category/' . $category->path_img);
    //         }

    //        $category->delete();

    //         DB::commit();

    //         return Redirect::back()->with('alert', 'Deleted category successfully!');
    //     } catch (\Exception $e) {
    //         DB::rollBack();

    //         return Redirect::back()->withErrors(['errors' => $e->getMessage()])->withInput();
    //     }
    // }
}
