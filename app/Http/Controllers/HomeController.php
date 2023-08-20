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

        return view('frontend.home.index', ['newProducts' => $newProducts]);
    }

    public function productDetail($id)
    {
        $productDetail = $this->homeService->getProductDetail($id);

        return view('frontend.product.detail', ['productDetail' => $productDetail]);
    }
}
