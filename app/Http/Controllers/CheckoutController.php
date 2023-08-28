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
use Illuminate\Support\Facades\Redirect;

class CheckoutController extends Controller
{
    private $checkoutService;

    public function __construct(CheckoutService $checkoutService)
    {
        $this->checkoutService = $checkoutService;
    }

    public function order()
    {
        $user = $this->checkoutService->getUser();
        $infor = $this->checkoutService->getInforUser();
        $carts = cart()->getContent();
        $total = cart()->getTotal();

        return view('frontend.checkout.oder', ['carts' => $carts, 'total' => $total, 'user' => $user, 'infor' => $infor]);
    }

    public function checkout(Request $request)
    {
        try {
            DB::beginTransaction();
            $cart = cart()->getContent();

            $order = Order::create([
                'email' => $request->input('email-address'),
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

            return Redirect::route('vnPay', ['oder_id' => $order->id, 'total', cart()->getTotal()]);

            //            cart()->destroy();
            Mail::to($order->email)
                ->queue(new OrderSuccessMail($order));

            return redirect()->route('checkout.success');
        } catch (\Exception $e) {
            DB::rollBack();

            throw $e;
        }
    }

    public function success()
    {
        return view('frontend.checkout.success');
    }
}
