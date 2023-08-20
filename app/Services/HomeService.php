<?php

namespace App\Services;

use App\Repositories\ProductRepository;

class HomeService
{
    private $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function getNewProducts($limit)
    {
        return $this->productRepository->getNewProducts($limit);
    }

    public function getProductDetail($id)
    {
        return $this->productRepository->getProductById($id);
    }
}
