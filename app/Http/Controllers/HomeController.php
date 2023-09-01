<?php

namespace App\Http\Controllers;

use App\Services\HomeService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    private $homeService;

    public function __construct(HomeService $homeService)
    {
        $this->homeService = $homeService;
    }

    public function index($limit = 8)
    {
        $newProducts = $this->homeService->getNewProducts($limit);
        $categories = $this->homeService->getCategory();
        $brands = $this->homeService->getBrand();

        return view('frontend.home.index', ['newProducts' => $newProducts, 'categories' => $categories, 'brands' => $brands]);
    }

    public function productDetail($id)
    {
        $productDetail = $this->homeService->getProductDetail($id);

        return view('frontend.product.detail', ['productDetail' => $productDetail]);
    }

    public function list()
    {
        $products = $this->homeService->getProducts();

        return view('frontend.product.list', ['products' => $products]);
    }

    public function listByCategory($id)
    {
        return view('frontend.product.list');
    }

    public function listByBrand($id)
    {
        return view('frontend.product.list');
    }

    public function myAccount()
    {
        return view('frontend.user.account');
    }
}
