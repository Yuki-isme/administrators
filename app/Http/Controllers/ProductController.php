<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ProductService;

class ProductController extends Controller
{
    private $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index()
    {
        $products = $this->productService->getAllProducts();

        return view('admin.product.index', ['products' => $products]);
    }

    public function create()
    {
        $categories = $this->productService->getAllCategories();
        $brands = $this->productService->getAllBrands();

        return view('admin.product.form', ['categories' => $categories, 'brands' => $brands]);
    }

    public function store(Request $request)
    {
        return $this->productService->store($request);
    }

    public function show(string $id)
    {
        //
    }

    public function edit($id)
    {
        $product = $this->productService->getProductById($id);

        return view('admin.product.form', ['product' => $product]);
    }

    public function update(Request $request, string $id)
    {
        return $this->productService->update($id, $request);
    }

    public function destroy($id)
    {
        return $this->productService->destroy($id);
    }
}
