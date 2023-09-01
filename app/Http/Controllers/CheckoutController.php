<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CheckoutService;
use App\Services\AddressService;

use App\Models\Order;
use App\Models\Item;
use App\Mail\OrderSuccessMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    private $checkoutService;
    private $addressService;

    public function __construct(CheckoutService $checkoutService, AddressService $addressService)
    {
        $this->checkoutService = $checkoutService;
        $this->addressService = $addressService;
    }

    public function order()
    {
        $user = $this->checkoutService->getInforUser();

        $provinces = $this->addressService->getProvinces();

        $carts = cart()->getContent();
        $total = cart()->getTotal();

        return view('frontend.checkout.oder', ['carts' => $carts, 'total' => $total, 'user' => $user, 'provinces' => $provinces]);
    }

    public function getDistricts(Request $request)
    {
        return $this->addressService->getDistricts($request);
    }

    public function getWards(Request $request)
    {
        return $this->addressService->getWards($request);
    }

    public function checkout(Request $request)
    {

        try {
            DB::beginTransaction();
            $cart = cart()->getContent();

            $order = Order::create([
                'name' => $request->name,
                'phone_number' => $request->phone_number,
                'email' => $request->email,
                'payment_method' => $request->payment_method == '1' ? 'Payment on delivery' : 'Pay via VNPAY',
                'province_code' => $request->province_code,
                'district_code' => $request->district_code,
                'ward_code' => $request->ward_code,
                'street' => $request->street,
                'house' => $request->house,
                'note' => $request->note,
                'status' => $request->payment_method == '1' ? 'Call to confirm order' : 'Place order success',
                'total' => cart()->getTotal(),
                'user_id' => Auth::guard('web')->check() ?  Auth::guard('web')->user()->id : null,
            ]);

            foreach ($cart as $id => $item) {
                Item::create([
                    'product_name' => $item['name'],
                    'price' => $item['price'],
                    'amount' => $item['amount'],
                    'product_id' => $id,
                    'order_id' => $order->id,
                ]);
            }

            $order = Order::with('items', 'province', 'district', 'ward')->find($order->id);
            //dd($order);
            DB::commit();

            if ($request->payment_method == '2') {
                return Redirect::route('vnPay', ['oder_id' => $order->id, 'total' => cart()->getTotal()]);
            }

            //            cart()->destroy();
            Mail::to($order->email)
                ->queue(new OrderSuccessMail($order));

            return view('frontend.checkout.success');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->withErrors(['common' => $e->getMessage()]);
        }
    }
}
