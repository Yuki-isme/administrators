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
        return $this->model->with('thumbnail')->where('is_hot', '1')->orderBy('created_at', 'desc')->take($limit)->get();
    }

    public function getStockProduct($id)
    {
        return $this->model->find($id)->stock ?? 0;
    }

    public function getPriceProduct($id)
    {
        return $this->model->find($id)->cart_price ?? 0;
    }

    //home

    public function getProducts()
    {
        return $this->model->with('thumbnail')->get();
    }

    public function getProduct($id)
    {
        return $this->model->with('thumbnail')->find($id);
    }
}
