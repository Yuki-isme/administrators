<?php

namespace App\Services;

use App\Repositories\OrderRepository;
use App\Repositories\ProductRepository;
use App\Repositories\ItemRepository;
use App\Repositories\StatusRepository;
use App\Repositories\ProvinceRepository;

use Illuminate\Support\Facades\DB;
use App\Exceptions\CommonException;
use Illuminate\Support\Facades\Redirect;

class OrderService
{
    private $orderRepository;
    private $productRepository;
    private $itemRepository;
    private $provinceRepository;
    private $statusRepository;
    private $statusDisabledMap = [
        1 => [3, 4, 5, 6, 7, 8],
        2 => [1, 4, 5, 6, 7, 8],
        3 => [1, 2, 5, 6, 7, 8],
        4 => [1, 2, 3, 6, 7, 8],
        5 => [1, 2, 3, 4, 7, 8],
        6 => [1, 2, 3, 4, 5, 7, 8],
        7 => [1, 2, 3, 4, 5, 6, 8],
        8 => [1, 2, 3, 4, 5, 6, 7],
    ];

    public function __construct(OrderRepository $orderRepository, ProductRepository $productRepository, ItemRepository $itemRepository, ProvinceRepository $provinceRepository, StatusRepository $statusRepository)
    {
        $this->orderRepository = $orderRepository;
        $this->productRepository = $productRepository;
        $this->itemRepository = $itemRepository;
        $this->provinceRepository = $provinceRepository;
        $this->statusRepository = $statusRepository;
    }

    public function statusDisabledMap()
    {
        return $this->statusDisabledMap;
    }

    public function statuses()
    {
        return $this->statusRepository->query()->get();
    }

    public function orders()
    {
        return $this->orderRepository->query()->with('items', 'province', 'district', 'ward', 'status')->orderBy('created_at', 'desc')->get();
    }

    public function completed()
    {
        return $this->orderRepository->query()->with('items', 'province', 'district', 'ward', 'status')
            ->whereBetween('status_id', [4, 6])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function processing()
    {
        return $this->orderRepository->query()->with('items', 'province', 'district', 'ward', 'status')
            ->where('status_id', '<', 5)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function requestCancel()
    {
        return $this->orderRepository->query()->with('items', 'province', 'district', 'ward', 'status')
            ->where('status_id', 7)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function canceled()
    {
        return $this->orderRepository->query()->with('items', 'province', 'district', 'ward', 'status')
            ->where('status_id', 8)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function status($request)
    {
        // dd($request->status_id);
        try {
            DB::beginTransaction();
            $order = $this->orderRepository->getById($request->order_id);

            if (!in_array($request->status_id, $this->statusDisabledMap[$order->status_id])) {
                $order->update([
                    'status_id' => $request->status_id
                ]);
                DB::commit();

                if ($request->status_id = 8) {
                    $this->refundStock($order->id);
                }

                $statuses = $this->statusRepository->query()->get();

                $html = view('admin.order.select-update', ['statuses' => $statuses, 'status_id' => $order->status_id, 'statusDisabledMap' => $this->statusDisabledMap])->render();


                return response()->json(['success' => true, 'message' => 'Status updated successfully', 'html' => $html]);
            } else {
                return response()->json(['success' => false]);
            }
        } catch (\Exception $e) {
            DB::rollBack();
        }
    }

    public function provinces()
    {
        return $this->provinceRepository->getProvinces();
    }

    public function getProducts($request)
    {
        $query = $this->productRepository->query();

        if ($request->q) {
            $query->where('name', 'like', "%$request->q%");
        }

        $products = $query->paginate(10, '*', 'page', $request->page);

        $data = [
            'lastPage' => $products->lastPage(),
            'data' => $products->map(function ($product) {
                return [
                    'id' => $product->id,
                    'text' => $product->name,
                    'image' => asset('storage/' . $product->thumbnail->url),
                    'name' => $product->name,
                    'price' => $product->cart_price,
                    'discount' => $product->price - $product->cart_price,
                    'stock' => $product->stock,
                ];
            }),
        ];

        return $data;
    }

    public function getProductInfo($request)
    {
        $selected_ids = $request->selected_ids ?? [];
        $product_ids = $request->product_ids ?? [];
        $amounts = $request->amounts ?? [];
        $remove_ids = [];

        $products_selected = $this->productRepository->query()->with('thumbnail')->whereIn('id', $selected_ids)->where('stock', '!=', '0')->get();

        $remove_ids = array_diff($selected_ids, $products_selected->pluck('id')->toArray());

        $table_update = view('admin.order.table-update', ['products_selected' => $products_selected, 'product_ids' => $product_ids, 'amounts' => $amounts])->render();

        return response()->json(['table_update' => $table_update, 'remove_ids' => $remove_ids]);
    }

    public function store($request)
    {
        try {
            $products = $this->productRepository->query()->whereIn('id', $request->products)
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
            $order = $this->orderRepository->query()->create([
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
                $this->itemRepository->query()->create([
                    'product_name' => $product->name,
                    'price' => $product->cart_price,
                    'discount' => $product->price - $product->cart_price,
                    'amount' => $request->amounts[$key],
                    'product_id' => $product->id,
                    'order_id' => $order->id,
                ]);

                $this->productRepository->query()->where('id', $product->id)->update([
                    'stock' => $product->stock - $request->amounts[$key],
                ]);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors(['common' => $e->getMessage()]);
        }
    }

    public function find(string $id)
    {
        return $this->orderRepository->query()->with('status', 'province', 'district', 'ward', 'items.product')->find($id);
    }

    public function update($request, string $id)
    {
        $order = $this->orderRepository->getById($id);

        try {
            DB::beginTransaction();

            $order->update([
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
                'status_id' => $request->status_id,
            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors(['common' => $e->getMessage()]);
        }
    }

    public function refundStock($id)
    {
        try {
            DB::beginTransaction();
            $order = $this->orderRepository->query()->with('items.product')->find($id);

            foreach ($order->items as $item) {
                $product = $this->productRepository->getById($item->product_id);

                $product->update([
                    'stock' => $product->stock + $item->amount,
                ]);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
        }
    }

    public function cancel($id)
    {
        try {
            DB::beginTransaction();

            $this->orderRepository->getById($id)->update([
                'status_id' => 8,
            ]);

            $this->refundStock($id);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors(['common' => $e->getMessage()]);
        }
    }

    public function notCancel($id)
    {
        try {
            DB::beginTransaction();

            $this->orderRepository->getById($id)->update([
                'status_id' => 1,
            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors(['common' => $e->getMessage()]);
        }
    }

    public function customerCancel($id)
    {
        try {
            DB::beginTransaction();

            $this->orderRepository->getById($id)->update([
                'status_id' => 7,
            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors(['common' => $e->getMessage()]);
        }
    }

    public function undoCancel($id)
    {
        try {
            DB::beginTransaction();

            $this->orderRepository->getById($id)->update([
                'status_id' => 1,
            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors(['common' => $e->getMessage()]);
        }
    }
}
