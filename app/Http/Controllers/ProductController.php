<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ProductService;
use Illuminate\Support\Facades\Redirect;


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
        $this->productService->store($request);

        return Redirect::route('products.index')->with('success', 'Created product successfully!');
    }

    public function show(string $id)
    {
        $product = $this->productService->getProductById($id);

        return view('admin.product.show', ['product' => $product]);
    }

    public function edit($id)
    {
        $product = $this->productService->getProductById($id);
        $categories = $this->productService->getAllCategories();
        $brands = $this->productService->getAllBrands();

        return view('admin.product.form', ['product' => $product, 'categories' => $categories, 'brands' => $brands]);
    }

    public function update(Request $request, string $id)
    {
        if($request->ajax()){
            return $this->productService->update($request, $id);
        }

        $this->productService->update($request, $id);

        return Redirect::route('products.index')->with('success', 'Updated product successfully!');
    }

    public function destroy($id)
    {
        $this->productService->destroy($id);

        return Redirect::back()->with('alert', 'Deleted product successfully!');
    }
}
