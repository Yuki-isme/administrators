<?php

namespace App\Services;
use App\Repositories\CategoryRepository;

class CategoryService
{
    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository){
        $this->categoryRepository = $categoryRepository;
    }

    public function getAllCategory(){
        return $this->categoryRepository->getCategories();
    }

    public function store($data){
        if (isset($data['img']) && $data['img']->isValid()) {
            // Continue with saving the category
            return $this->categoryRepository->store($data);
        } else {
            return ['error' => 'Invalid image or no image uploaded'];
        }
    }
    public function getCategoryById($id){
        return $this->categoryRepository->getCategoryById($id);
    }

    public function deleteCategory($id)
    {
        // Kiểm tra xem danh mục có tồn tại không
        $category = $this->categoryRepository->getCategoryById($id);

        if (!$category) {
            return false;
        }

        // Thực hiện xóa danh mục
        return $this->categoryRepository->delete($id);
    }
}
