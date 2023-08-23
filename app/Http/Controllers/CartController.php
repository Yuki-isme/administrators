<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  App\Services\CartService;

class CartController extends Controller
{
    private $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function add($id, Request $request)
    {
        $this->cartService->add($id, $request);

        if($request->ajax()){
            return view('frontend.layout.components.header');
        }

        return redirect()->route('index');
    }

    public function index()
    {
        $products = $this->cartService->index();
        $total = $this->cartService->getTotal();
        return view('frontend.checkout.cart', ['products' => $products, 'total' => $total]);
    }
}
