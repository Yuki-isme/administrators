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
            return $this->categoryRepository->store($data);
        } else {
            return ['error' => 'Invalid image or no image uploaded'];
        }
    }
    public function getCategoryById($id)
    {
        return $this->categoryRepository->getById($id);
    }

    public function update($Id, $data)
    {

        $category = $this->categoryRepository->getById($Id);
        if (!$category) {
            return ['error' => 'Không tìm thấy danh mục'];
        }

        return $category = $this->categoryRepository->update($Id, $data);
    }

    public function deleteCategory($id)
    {
        // Kiểm tra xem danh mục có tồn tại không
        $category = $this->categoryRepository->getById($id);

        if (!$category) {

            return ['error' => 'Không tìm thấy category'];
        }

        // Thực hiện xóa danh mục
        return $this->categoryRepository->delete($id);
    }

    public function getChildCategories()
    {
        return $this->categoryRepository->getChildCategories();
    }
}
