<?php

namespace App\Repositories;

use App\Models\Product;

class ProductRepository extends BaseRepository
{

    private $model;

    public function __construct(Product $model)
    {
        $this->model = $model;
        parent::__construct($model);
    }

    public function getAllProducts()
    {
        return $this->model->with('category', 'brand')->get();
    }

    public function getProductById($id){
        // $name = 'catalog';
        // $product = Product::with([
        //     'media' => function ($sql) use ($name) {
        //         return $sql->where('type', $name);
        //     }
        // ])
        //     ->get();
        // dd($product);

        $product = $this->model->with('category.parent', 'brand', 'thumbnail', 'media', 'attributeValue.attribute')->find($id);

        return $product;
    }

    public function getNewProducts($limit)
    {
        return $this->model->with('thumbnail')->orderBy('created_at', 'desc')->take($limit)->get();
    }
}
