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

    public function getCategories()
    {
        return $this->categoryRepository->getCategories();
    }

    public function getAllCategories()
    {
        return $this->categoryRepository->getAllCategories();
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
            $category = $this->categoryRepository->getCategoryById($id);

            if (!$category) {
                throw new \Exception('Category not found!');
            }

            DB::BeginTransaction();

            if ($request->ajax()) {
                if ($this->categoryRepository->getParentById($id)) {
                    return response()->json([
                        'title' => 'Update Status',
                        'message' => 'Unable to disable active parent category containing active subcategories',
                        'is_active' => $category->is_active,
                    ]);
                } else if ($category->products) {
                    return response()->json([
                        'title' => 'Update Status',
                        'message' => 'Unable to disable categories containing products',
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
                if ($category->thumbnail) {
                    Storage::disk('public')->delete($category->thumbnail->url);
                }
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

            $category = $this->categoryRepository->getCategoryById($id);

            if (!$category) {
                throw new \Exception('Category not found');
            }

            if ($category->products->count() > 0) {
                throw new \Exception('Cannot delete category have products');
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

    public function browseTrees($parent)
    {
        $leafCategories = [];

        if ($parent->child->isEmpty()) {
            // Nếu không có con nào, trả về category hiện tại
            $leafCategories[] = $parent;
        } else {
            // Nếu có con, lặp qua từng con và thực hiện đệ quy
            foreach ($parent->child as $child) {
                $leafCategories = array_merge($leafCategories, $this->browseTrees($child));
            }
        }

        return $leafCategories;
    }

    public function getChildrenByParent_id($request)
    {
        $term = $request->term;
        $parent_id = $request->parent_id;

        $parent = Category::find($parent_id);
        $leafCategories = [];

        if ($parent) {
            $leafCategories = $this->browseTrees($parent);
        }

        // Lọc theo $term nếu có
        if (!empty($term)) {
            $leafCategories = collect($leafCategories)->filter(function ($category) use ($term) {
                return stripos($category->name, $term) !== false;
            })->toArray();
        }

        return response()->json($leafCategories);
    }

    public function getParentByChildren_id($request)
    {
        $category = Category::find($request->childId);
        $parentCategory = null;

        while ($category) {
            $parentCategory = $category;
            $category = $category->parent;
        }

        if ($parentCategory) {
            return response()->json($parentCategory);
        }

        return response()->json(null);
    }
}
