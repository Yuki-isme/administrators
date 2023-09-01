<?php

namespace App\Services;

use App\Repositories\ProductRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\BrandRepository;

class HomeService
{
    private $productRepository;
    private $categoryRepository;
    private $brandRepository;

    public function __construct(ProductRepository $productRepository, CategoryRepository $categoryRepository, BrandRepository $brandRepository)
    {
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
        $this->brandRepository = $brandRepository;
    }

    public function getNewProducts($limit)
    {
        return $this->productRepository->getNewProducts($limit);
    }

    public function getProductDetail($id)
    {
        return $this->productRepository->getProductById($id);
    }

    public function getCategory()
    {
        return $this->categoryRepository->getAllCategories();
    }

    public function getBrand()
    {
        return $this->brandRepository->getAllBrands();
    }

    public function getProducts()
    {
        return $this->productRepository->getProducts();
    }
}
