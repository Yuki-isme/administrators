<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CheckoutService;
use App\Services\CartService;

use App\Models\Order;
use App\Models\Item;
use App\Mail\OrderSuccessMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

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

    public function checkout(Request $request)
    {
        try {
            DB::beginTransaction();
            $cart = $this->cartService->getContent();

            $order = Order::create([
                'email' => $request->inpu('email'),
                'status' => 'placed',
            ]);

            foreach ($cart as $id => $item) {
                $orderItem = Item::create([
                    'product_name' => $item['name'],
                    'price' => $item['price'],
                    'amount' => $item['amount'],
                    'product_id' => $id,
                    'order_id' => $order->id,
                ]);
            }
            DB::commit();

            Mail::to($order->email)->send(new OrderSuccessMail($order));

        } catch (\Exception $e) {

        }
    }
}
