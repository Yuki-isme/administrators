<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Order;
use App\Models\Status;
use App\Models\Product;
use App\Models\Item;
use Illuminate\Support\Facades\DB;
use App\Services\AddressService;

class OrderController extends Controller
{
    private $addressService;
    private $statusDisabledMap = [
        1 => [3, 4, 5, 6],
        2 => [1, 4, 5, 6],
        3 => [1, 2, 5, 6, 7, 8],
        4 => [1, 2, 3, 6, 7, 8],
        5 => [1, 2, 3, 4, 7, 8],
        6 => [1, 2, 3, 4, 5, 7, 8],
        7 => [1, 2, 3, 4, 5, 6],
        8 => [1, 2, 3, 4, 5, 6, 7, 8],
    ];

    public function __construct(AddressService $addressService)
    {
        $this->addressService = $addressService;
    }

    public function index()
    {
        $orders = Order::with('items', 'province', 'district', 'ward', 'status')->orderBy('created_at', 'desc')->get();
        $statuses = Status::get();

        return view('admin.order.index', ['orders' => $orders, 'statuses' => $statuses, 'statusDisabledMap' => $this->statusDisabledMap]);
    }

    public function completed()
    {
        $orders = Order::with('items', 'province', 'district', 'ward', 'status')
            ->whereBetween('status_id', [4, 7])
            ->orderBy('created_at', 'desc')
            ->get();
        $statuses = Status::get();

        return view('admin.order.completed', ['orders' => $orders, 'statuses' => $statuses, 'statusDisabledMap' => $this->statusDisabledMap]);
    }

    public function processing()
    {
        $orders = Order::with('items', 'province', 'district', 'ward', 'status')
            ->where('status_id', '<', 5)
            ->orderBy('created_at', 'desc')
            ->get();
        $statuses = Status::get();

        return view('admin.order.processing', ['orders' => $orders, 'statuses' => $statuses, 'statusDisabledMap' => $this->statusDisabledMap]);
    }

    public function canceled()
    {
        $orders = Order::with('items', 'province', 'district', 'ward', 'status')
            ->where('status_id', '>', 6)
            ->orderBy('created_at', 'desc')
            ->get();
        $statuses = Status::get();

        return view('admin.order.canceled', ['orders' => $orders, 'statuses' => $statuses, 'statusDisabledMap' => $this->statusDisabledMap]);
    }

    public function status(Request $request)
    {
        try {
            DB::beginTransaction();
            $order = Order::find($request->order_id);

            if (!in_array($request->status_id, $this->statusDisabledMap[$order->status_id])) {
                $order->update([
                    'status_id' => $request->status_id
                ]);
                DB::commit();

                $statuses = Status::get();

                $html = view('admin.order.select-update', ['statuses' => $statuses, 'status_id' => $request->status_id, 'statusDisabledMap' => $this->statusDisabledMap])->render();


                return response()->json(['success' => true, 'message' => 'Status updated successfully', 'html' => $html]);
            } else {
                return response()->json(['success' => false]);
            }
        } catch (\Exception $e) {
            DB::rollBack();
        }
    }

    public function create()
    {
        $statuses = Status::get();
        $provinces = $this->addressService->getProvinces();

        return view('admin.order.form', ['provinces' => $provinces, 'statuses' => $statuses, 'statusDisabledMap' => $this->statusDisabledMap]);
    }

    public function store(Request $request)
    {
        try {
            $products = Product::whereIn('id', $request->products)
                ->orderByRaw('FIELD(id, ' . implode(',', $request->products) . ')')
                ->get();

            $total = 0;
            $discount = 0;

            foreach ($products as $key => $product) {
                if ($request->amounts[$key] <= $product->stock) {
                    $total += $product->cart_price * $request->amounts[$key];
                    $discount += $product->price * $request->amounts[$key] - $product->cart_price * $request->amounts[$key];
                } else {
                    throw new \Exception('Khong du so luong');
                }
            }

            DB::beginTransaction();
            $order = Order::create([
                'name' => $request->name,
                'phone_number' => $request->phone_number,
                'email' => $request->email,
                'payment_method' => $request->payment_method,
                'payment_status' => $request->payment_status,
                'province_code' => $request->province_code,
                'district_code' => $request->district_code,
                'ward_code' => $request->ward_code,
                'street' => $request->street,
                'house' => $request->house,
                'note' => $request->note ?? '',
                'note_order' => $request->note_order,
                'total' => $total,
                'discount' => $discount,
                'status_id' => $request->status_id,
            ]);

            foreach ($products as $key => $product) {
                Item::create([
                    'product_name' => $product->name,
                    'price' => $product->cart_price,
                    'discount' => $product->price - $product->cart_price,
                    'amount' => $request->amounts[$key],
                    'product_id' => $product->id,
                    'order_id' => $order->id,
                ]);

                Product::where('id', $product->id)->update([
                    'stock' => $product->stock - $request->amounts[$key],
                ]);
            }
            return view('admin.order.index');
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors(['common' => $e->getMessage()]);
        }
    }

    public function show(string $id)
    {
        $order = Order::with('status', 'province', 'district', 'ward', 'items.product')->find($id);

        return view('admin.order.show', ['order' => $order]);
    }

    public function edit($id)
    {

        $order = Order::with('district', 'ward', 'items.product.thumbnail', 'status')->find($id);

        if ($order->status_id > 2) {
            return redirect()->route('orders.index');
        }
        $statuses = Status::get();
        $provinces = $this->addressService->getProvinces();

        return view('admin.order.form', ['order' => $order, 'provinces' => $provinces, 'statuses' => $statuses, 'statusDisabledMap' => $this->statusDisabledMap]);
    }

    public function update(Request $request, string $id)
    {
        $order = Order::find($id);
        if($order->status_id > 2) {
            return redirect()->route('orders.index');
        }else{
            try {
                $items = Item::where('order_id', $id)->orderByRaw('FIELD(product_id, ' . implode(',', $request->products) . ')')->get();

                $products = Product::whereIn('id', $request->products)
                    ->orderByRaw('FIELD(id, ' . implode(',', $request->products) . ')')
                    ->get();

                $total = 0;
                $discount = 0;

                foreach ($products as $key => $product) {
                    if(isset($items[$key])){
                        if($items[$key]->amount >= $request->amounts[$key]){
                            $total += $items[$key]->price * $request->amounts[$key];
                            $discount += $items[$key]->discount * $request->amounts[$key];
                        }else if($items[$key]->amount < $request->amounts[$key]){
                            $total += $items[$key]->price * $items[$key]->amount;
                            $discount += $items[$key]->discount * $items[$key]->amount;
                            $total += $product->cart_price * ($request->amounts[$key] - $items[$key]->amount);
                            $discount += $product->price * ($request->amounts[$key] - $items[$key]->amount) - $product->cart_price * ($request->amounts[$key] - $items[$key]->amount);
                        }
                    }else{
                        $total += $product->cart_price * $request->amounts[$key];
                        $discount += $product->price * $request->amounts[$key] - $product->cart_price * $request->amounts[$key];
                    }
                }

                dd($total, $discount);

                DB::beginTransaction();
                $order->create([
                    'name' => $request->name,
                    'phone_number' => $request->phone_number,
                    'email' => $request->email,
                    'payment_method' => $request->payment_method,
                    'payment_status' => $request->payment_status,
                    'province_code' => $request->province_code,
                    'district_code' => $request->district_code,
                    'ward_code' => $request->ward_code,
                    'street' => $request->street,
                    'house' => $request->house,
                    'note' => $request->note ?? '',
                    'note_order' => $request->note_order,
                    'total' => $total,
                    'discount' => $discount,
                    'status_id' => $request->status_id,
                ]);

                foreach ($products as $key => $product) {
                    Item::create([
                        'product_name' => $product->name,
                        'price' => $product->cart_price,
                        'discount' => $product->price - $product->cart_price,
                        'amount' => $request->amounts[$key],
                        'product_id' => $product->id,
                        'order_id' => $order->id,
                    ]);

                    Product::where('id', $product->id)->update([
                        'stock' => $product->stock - $request->amounts[$key],
                    ]);
                }
                return view('admin.order.index');
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->back()->withInput()->withErrors(['common' => $e->getMessage()]);
            }
        }

    }
}
