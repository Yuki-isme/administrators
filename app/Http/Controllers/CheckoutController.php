<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CheckoutService;
use App\Services\CartService;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    private $checkoutService;
    private $cartService;

    public function __construct(CheckoutService $checkoutService, CartService $cartService)
    {
        $this->checkoutService = $checkoutService;
        $this->cartService = $cartService;
    }

    public function order()
    {
        $user = $this->checkoutService->getUser();
        $infor = $this->checkoutService->getInforUser();
        $carts = $this->cartService->getContent();
        $total = $this->cartService->getTotal();

        return view('frontend.checkout.oder', ['carts' => $carts, 'total' => $total, 'user' => $user, 'infor' => $infor]);
    }
}
