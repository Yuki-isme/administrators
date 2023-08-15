<?php

namespace App\Services;

use App\Repositories\CategoryRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use App\Exceptions\CommonException;
use App\Repositories\MediaRepository;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

use App\Models\Category;

class CategoryService
{
    private $categoryRepository;
    private $mediaRepository;

    public function __construct(CategoryRepository $categoryRepository, MediaRepository $mediaRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->mediaRepository = $mediaRepository;
    }

    public function getAllCategories()
    {
        return $this->categoryRepository->getAllCategories(); //lấy tất cả category có parent_id = 0
    }

    public function store($request)
    {
        try {

            DB::beginTransaction();

            $category = $this->categoryRepository->create([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'description' => $request->description,
                'parent_id' => $request->parent_id ?? 0,
                'is_active' => $request->is_active ?? 0,
            ]);

            if ($request->hasFile('thumbnail')) {
                $thumbImage = $request->file('thumbnail');
                $imageName = Carbon::now()->format('Y-m-d-H-i-s') . '-' . $thumbImage->getClientOriginalName();
                $url =  $thumbImage->storeAs('thumbnails', $imageName, 'public');

                $this->mediaRepository->create([
                    'title' => $imageName,
                    'url' => $url,
                    'type' => 'thumbnail',
                    'mediable_type' => Category::class,
                    'mediable_id' => $category->id,
                ]);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            throw new CommonException($e->getMessage());
        }
    }


    public function getCategoryById($id)
    {
        return $this->categoryRepository->getById($id); //lấy để chỉnh sửa dùng chung
    }

    public function update($request, $id)
    {
        try {
            $category = $this->categoryRepository->getById($id);

            if (!$category) {
                throw new \Exception('Category not found!');
            }

            DB::BeginTransaction();

            if ($request->ajax()) {
                if ($this->categoryRepository->getParentById($id)) {
                    return response()->json([
                        'title' => 'Update Status',
                        'message' => 'Unable to disable active parent category containing subcategories',
                        'is_active' => $category->is_active,
                    ]);
                }
                $category = $this->categoryRepository->update($id, [
                    'is_active' => $request->is_active,

                ]);
                DB::commit();

                return response()->json([
                    'title' => 'Update Status',
                    'message' => 'Update Status for ' . $category->name . ' successfully!',
                    'is_active' => $category->is_active,
                ]);
            }

            if ($this->categoryRepository->getParentById($id) && is_null($request->is_active)) { //nếu là parent thì không thể turn off is_active
                throw new \Exception('Unable to disable active parent category containing subcategories');
            }

            $category = $this->categoryRepository->update($id, [
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'description' => $request->description,
                'parent_id' => $request->parent_id ?? 0,
                'is_active' => $request->is_active ?? 0,
            ]);

            if ($request->hasFile('thumbnail')) {
                Storage::disk('public')->delete($category->thumbnail[0]->url);
                $this->mediaRepository->deleteMediaByProductIDAndType($category->id, 'thumbnail');
                $thumbImage = $request->file('thumbnail');
                $imageName = Carbon::now()->format('Y-m-d-H-i-s') . '-' . $thumbImage->getClientOriginalName();
                $url =  $thumbImage->storeAs('thumbnails', $imageName, 'public');

                $this->mediaRepository->create([
                    'title' => $imageName,
                    'url' => $url,
                    'type' => 'thumbnail',
                    'mediable_type' => Category::class,
                    'mediable_id' => $category->id,
                ]);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            throw new CommonException($e->getMessage());
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

            if ($category->thumbnail) {
                Storage::disk('public')->delete($category->thumbnail->url);
            }

            $this->mediaRepository->deleteMediaByMediableID($category->id, Category::class);

            $category->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            throw new CommonException($e->getMessage());
        }
    }

    //sub
    public function getAllSub()
    {
        return $this->categoryRepository->getAllSub();
    }

    public function getChildrenByParent_id($request)
    {
        if ($request->parent_id == 0) {
            return response()->json([]);
        }

        $categories = $this->categoryRepository->getChildrenByParent_id($request->parent_id);

        $childCategory = $categories->map(function ($category) {
            $is_active = $category->is_active;
            $disabled = $is_active ? '' : 'disabled'; // Thêm 'disabled' vào thẻ nếu $is_active == 0

            return [
                'id' => $category->id,
                'text' => $category->name,
                'is_active' => $category->is_active,
                'disabled' => $disabled, // Thêm thuộc tính 'disabled' vào mảng nếu cần
            ];
        });

        return response()->json($childCategory);
    }

}
