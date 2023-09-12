<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CheckoutService;
use App\Services\AddressService;

use App\Models\Order;
use App\Models\Item;
use App\Models\Info;
use App\Models\User;
use App\Models\Cart;
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
        $discount = cart()->getDiscount();

        return view('frontend.checkout.order', ['carts' => $carts, 'total' => $total, 'user' => $user, 'provinces' => $provinces, 'discount' => $discount]);
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

            $order = Order::create([
                'name' => $request->name,
                'phone_number' => $request->phone_number,
                'email' => $request->email,
                'province_code' => $request->province_code,
                'district_code' => $request->district_code,
                'ward_code' => $request->ward_code,
                'street' => $request->street,
                'house' => $request->house,
                'note' => $request->note,
                'total' => cart()->getTotal(),
                'discount' => cart()->getDiscount(),
                'user_id' => Auth::guard('web')->check() ?  Auth::guard('web')->user()->id : null,
                'status_id' => $request->payment_method == '2' ? 2 : 1,
            ]);

            $cart = cart()->getContent();

            foreach ($cart as $id => $item) {
                Item::create([
                    'product_name' => $item['name'],
                    'price' => $item['price'],
                    'discount' => $item['discount'],
                    'amount' => $item['amount'],
                    'product_id' => $id,
                    'order_id' => $order->id,
                ]);
            }

            if ($request->save && Auth::guard('web')->check()) {
                Info::updateOfCreate([
                    'id' => $request->info_id,
                ],
                [
                    'user_id' => Auth::guard('web')->user()->id,
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone_number' => $request->phone_number,
                    'province_code' => $request->province_code,
                    'district_code' => $request->district_code,
                    'ward_code' => $request->ward_code,
                    'street' => $request->street,
                    'house' => $request->house,
                    'note' => $request->note,
                ]);
            }

            DB::commit();

            if ($request->payment_method == '2') {
                return Redirect::route('vnPay', ['order_id' => $order->id, 'total' => cart()->getTotal()]);
            }

            $order = Order::with('items', 'province', 'district', 'ward')->find($order->id);
            Mail::to($order->email)
                ->queue(new OrderSuccessMail($order));

            return view('frontend.checkout.success');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->withErrors(['common' => 'Something went wrong, try again later!']);
        }
    }

    public function success()
    {
        return view('frontend.checkout.success');
    }

    public function failed()
    {
        return view('frontend.checkout.failed');
    }
}
