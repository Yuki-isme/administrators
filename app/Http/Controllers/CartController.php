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
        $check = $this->cartService->add($id, $request);

        if($check == 'amount'){
            return response()->json(['success' => false, 'message'=> 'So luong san pham khong du']);
        }else if($check == 'stock'){
            return response()->json(['success' => false, 'message'=> 'San pham da het hang']);
        }else{
            return response()->json(['success' => true, 'count' => count(cart()->getContent())]);
        }
    }

    public function index()
    {
        $total = $this->cartService->getTotal();
        $discount = $this->cartService->getDiscount();

        return view('frontend.checkout.cart', ['total' => $total, 'discount' => $discount]);
    }

    public function deleteItem($id)
    {
        $this->cartService->remove($id);
        $discount = $this->cartService->getDiscount();
        $cart = view('frontend.checkout.update.cart')->render();
        $total = view('frontend.checkout.update.total', ['total' => $this->cartService->getTotal(), 'discount' => $discount])->render();

        return response()->json(['count' => count(cart()->getContent()), 'cart' => $cart, 'total' => $total]);
    }

    public function updateAmount($id, Request  $request)
    {
        $amount = $request->amount;

        if ($amount <= 0) {
            return response()->json(['success' => false,'message'=> 'Số lượng sản phẩm không hợp lệ.']);
        }

        $this->cartService->updateAmount($id, $amount);
        $discount = $this->cartService->getDiscount();
        $cart = view('frontend.checkout.update.cart')->render();
        $total = view('frontend.checkout.update.total', ['total' => $this->cartService->getTotal(), 'discount' => $discount])->render();

        return response()->json(['count' => count(cart()->getContent()), 'cart' => $cart, 'total' => $total]);
    }
}
