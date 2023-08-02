<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ProductService;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Carbon;

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
        $thumbImages = $request->file('thumbnail');
                $imagesName = Carbon::now() . '-' . $thumbImages->getClientOriginalName();
                dd($thumbImages->storeAs('thumbnails', $imagesName, 'public'));
        $this->productService->store($request);

        return Redirect::route('products.index')->with('success', 'Created product successfully!');
    }

    public function show(string $id)
    {
        //
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

        $this->productService->update($id, $request);

        return Redirect::route('products.index')->with('success', 'Updated product successfully!');
    }

    public function destroy($id)
    {
        $this->productService->destroy($id);

        return Redirect::back()->with('alert', 'Deleted product successfully!');
    }
}
