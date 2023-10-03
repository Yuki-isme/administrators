<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Order;
use App\Models\Status;
use App\Models\Product;
use App\Models\Item;
use Illuminate\Support\Facades\DB;
use App\Services\OrderService;
use Illuminate\Support\Facades\Redirect;

class OrderController extends Controller
{
    private $orderService;
    private $statusDisabledMap;
    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
        $this->statusDisabledMap = $this->orderService->statusDisabledMap();
    }

    public function index()
    {
        $this->authorize('viewAny', Order::class);
        $orders = $this->orderService->orders();
        $statuses = $this->orderService->statuses();

        return view('admin.order.index', ['orders' => $orders, 'statuses' => $statuses, 'statusDisabledMap' => $this->statusDisabledMap]);
    }

    public function completed()
    {
        $this->authorize('viewAnyCompleted', Order::class);
        $orders = $this->orderService->completed();
        $statuses = $this->orderService->statuses();

        return view('admin.order.completed', ['orders' => $orders, 'statuses' => $statuses, 'statusDisabledMap' => $this->statusDisabledMap]);
    }

    public function processing()
    {
        $this->authorize('viewAnyProcessing', Order::class);
        $orders = $this->orderService->processing();
        $statuses = $this->orderService->statuses();

        return view('admin.order.processing', ['orders' => $orders, 'statuses' => $statuses, 'statusDisabledMap' => $this->statusDisabledMap]);
    }

    public function requestCancel()
    {
        $this->authorize('viewAnyRequestCancel', Order::class);
        $orders = $this->orderService->requestCancel();
        $statuses = $this->orderService->statuses();

        return view('admin.order.request-cancel', ['orders' => $orders, 'statuses' => $statuses, 'statusDisabledMap' => $this->statusDisabledMap]);
    }

    public function canceled()
    {
        $this->authorize('viewAnyCanceled', Order::class);
        $orders = $this->orderService->canceled();
        $statuses = $this->orderService->statuses();

        return view('admin.order.canceled', ['orders' => $orders, 'statuses' => $statuses, 'statusDisabledMap' => $this->statusDisabledMap]);
    }

    public function status(Request $request)
    {
        return $this->orderService->status($request);
    }

    public function create()
    {
        $this->authorize('create', Order::class);
        $statuses = $this->orderService->statuses();
        $provinces = $this->orderService->provinces();

        return view('admin.order.form', ['provinces' => $provinces, 'statuses' => $statuses, 'statusDisabledMap' => $this->statusDisabledMap]);
    }

    public function getProducts(Request $request)
    {
        $products = $this->orderService->getProducts($request);

        return response()->json($products);
    }

    public function getProductInfo(Request $request)
    {
        return $this->orderService->getProductInfo($request);
    }

    public function store(Request $request)
    {
        $this->authorize('create', Order::class);
        $this->orderService->store($request);

        return Redirect::route('orders.index');
    }

    public function show(string $id)
    {
        $order = $this->orderService->find($id);

        return view('admin.order.show', ['order' => $order]);
    }

    public function edit($id)
    {
        $this->authorize('update', Order::class);
        $order = $this->orderService->find($id);

        if ($order->status_id > 2) {
            return Redirect::back();
        }

        $statuses = $this->orderService->statuses();
        $provinces = $this->orderService->provinces();

        return view('admin.order.form-edit', ['order' => $order, 'provinces' => $provinces, 'statuses' => $statuses, 'statusDisabledMap' => $this->statusDisabledMap]);
    }

    public function update(Request $request, string $id)
    {
        $this->authorize('update', Order::class);
        $order = $this->orderService->find($id);
        if ($order->status_id > 2) {
            return Redirect::back();
        } else {
            $this->orderService->update($request, $id);

            return Redirect::route('orders.index');
        }
    }

    public function cancel($id)
    {
        $this->authorize('cancel', Order::class);
        $order = $this->orderService->find($id);

        if ($order->status_id < 3 || $order->status_id == 7) {
            $this->orderService->cancel($id);

            return Redirect::route('orders.canceled')->with('success', 'Cancel order successfully!');
        } else {
            return Redirect::back();
        }
    }

    public function notCancel($id)
    {
        $this->authorize('notCancel', Order::class);
        $order = $this->orderService->find($id);

        if ($order->status_id == 7) {
            $this->orderService->notCancel($id);

            return Redirect::route('orders.requestCancel')->with('success', 'Not allow cancel order successfully!');
        } else {
            return Redirect::back();
        }
    }

    public function initialization($id)
    {
        $this->authorize('initialization', Order::class);
        $order = $this->orderService->find($id);
        $statuses = $this->orderService->statuses();
        $provinces = $this->orderService->provinces();

        return view('admin.order.form', ['order' => $order, 'provinces' => $provinces, 'statuses' => $statuses, 'statusDisabledMap' => $this->statusDisabledMap]);
    }

    public function customerCancel(Request $request)
    {
        $order = $this->orderService->find($request->order_id);

        if ($order->status_id < 3 || $order->status_id == 7) {
            $this->orderService->cancel($request->order_id);

            return Redirect::route('orderCancelled')->with('success', 'Cancel order successfully!');
        } else {
            return Redirect::back();
        }
    }

    public function customerUndoCancel(Request $request)
    {
        $order = $this->orderService->find($request->order_id);

        if ($order->status_id == 7) {
            $this->orderService->undoCancel($request->order_id);

            return Redirect::route('orderPending')->with('success', 'Undo cancel order successfully!');
        } else {
            return Redirect::back();
        }
    }
}
