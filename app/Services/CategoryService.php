<?php

namespace App\Services;

use App\Repositories\CategoryRepository;

class CategoryService
{
    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function getAllCategory()
    {
        return $this->categoryRepository->getCategories();
    }

    public function store($data)
    {
        if (isset($data['img']) && $data['img']->isValid()) {
            // Continue with saving the category
            return $this->categoryRepository->store($data);
        } else {
            return ['error' => 'Invalid image or no image uploaded'];
        }
    }
    public function getCategoryById($id)
    {
        return $this->categoryRepository->getById($id);
    }

    public function update($categoryId, $data)
    {

        $category = $this->categoryRepository->getById($categoryId);
        if (!$category) {
            return ['error' => 'Không tìm thấy danh mục'];
        }

        if (isset($data['img']) && $data['img']->isValid()) {
            // Continue with saving the category
            $category = $this->categoryRepository->update($categoryId, $data);
        } else {
            return ['error' => 'Vui lòng tải lên tệp ảnh hợp lệ'];
        }

        return $category;
    }

    public function deleteCategory($id)
    {
        // Kiểm tra xem danh mục có tồn tại không
        $category = $this->categoryRepository->getById($id);

        if (!$category) {

            return false;
        }

        // Thực hiện xóa danh mục
        return $this->categoryRepository->delete($id);
    }

    public function get_child(){
        return $this->categoryRepository->get_child();
    }
}
