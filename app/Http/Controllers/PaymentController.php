<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Models\Order;
use App\Mail\OrderSuccessMail;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function vnPay(Request $request)
    {
        $vnp_Url = config('payment.vnpay.url');
        $vnp_HashSecret = config('payment.vnpay.merchant_secret');
        $vnp_TxnRef = $request->oder_id; //Mã giao dịch thanh toán tham chiếu của merchant
        $vnp_Amount = $request->total; // Số tiền thanh toán
        $vnp_Locale = config('payment.vnpay.locale'); //Ngôn ngữ chuyển hướng thanh toán
        $vnp_BankCode = config('payment.vnpay.bankcode'); //Mã phương thức thanh toán
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR']; //IP Khách hàng thanh toán

        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => config('payment.vnpay.merchant_id'),
            "vnp_Amount" => $vnp_Amount * 100,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => "Thanh toan GD:" . $vnp_TxnRef,
            "vnp_OrderType" => "other",
            "vnp_ReturnUrl" => route('vnPayReturn', ['oder_id' => $request->oder_id]),
            "vnp_TxnRef" => $vnp_TxnRef,
            "vnp_ExpireDate" => Carbon::now()->addMinutes(30)->format('YmdHis')
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }

        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret); //
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        header('Location: ' . $vnp_Url);
        die();
    }

    public function vnPayReturn(Request $request)
    {
        if ($request->vnp_TransationStatus == '00') {
            $order = Order::with('items', 'province', 'district', 'ward')->find($request->oder_id);

            try {
                DB::beginTransaction();
                $order->update([
                    'payment_method' => 'Pay via VNPAY',
                    'status' => 'Place order success',
                ]);
                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();
            }

            Mail::to($order->email)
                ->queue(new OrderSuccessMail($order));

            return view('frontend.checkout.success');
        }
        return view('frontend.checkout.failed');
    }
}
