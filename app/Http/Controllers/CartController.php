<?php

namespace App\Http\Controllers;

use App\Exceptions\CommonException;
use Illuminate\Http\Request;
use  App\Services\CartService;

use App\Repositories\ProductRepository;

class CartController extends Controller
{
    private $cartService;
    private $productRepository;

    public function __construct(CartService $cartService, ProductRepository $productRepository)
    {
        $this->cartService = $cartService;
        $this->productRepository = $productRepository;
    }

    public function add($id, Request $request)
    {
        $product = $this->productRepository->getById($id);

        if(!$product){
            throw new CommonException();
        }
        if($request->amout && $request->amout>$product->stock){
            throw new CommonException('So luong san pham khong du');
        }

        $this->cartService->add($id, $product->name, $product->cart_price, $request->amount ?? 1, $product->thumbnail->url ?? '');

        if($request->ajax()){
            return view('frontend.layout.components.header');
        }

        return redirect()->route('frontend.index');
    }

    public function index()
    {
        return view('frontend.checkout.cart');
    }
}
