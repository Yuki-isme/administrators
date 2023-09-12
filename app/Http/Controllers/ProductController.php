<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ProductService;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\Product\ProductRequest;

use App\Models\Product;
use App\Models\Order;

class ProductController extends Controller
{
    private $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }



    public function index()
    {
        $products = $this->productService->getAllProducts();

        return view('admin.product.index', ['products' => $products]);
    }

    public function create()
    {
        $categories = $this->productService->getAllCategories();
        $brands = $this->productService->getAllBrands();

        return view('admin.product.form', ['categories' => $categories, 'brands' => $brands]);
    }

    public function store(ProductRequest $request)
    {

        $this->productService->store($request);

        return Redirect::route('products.index')->with('success', 'Created product successfully!');
    }

    public function show(string $id)
    {
        $product = $this->productService->getProductById($id);

        return view('admin.product.show', ['product' => $product]);
    }

    public function edit($id)
    {
        $product = $this->productService->getProductById($id);
        $categories = $this->productService->getAllCategories();
        $brands = $this->productService->getAllBrands();

        return view('admin.product.form', ['product' => $product, 'categories' => $categories, 'brands' => $brands]);
    }

    public function update(Request $request, string $id)
    {
        if ($request->ajax()) {
            return $this->productService->update($request, $id);
        }

        $this->productService->update($request, $id);

        return Redirect::route('products.index')->with('success', 'Updated product successfully!');
    }

    public function destroy($id)
    {
        $this->productService->destroy($id);

        return Redirect::back()->with('alert', 'Deleted product successfully!');
    }

    public function uploadImage(Request $request)
    {
        if ($request->hasFile('file')) {
            $imagePath = $request->file('file')->store('images', 'public');
            return response()->json(['location' => asset('storage/' . $imagePath)]);
        }
        return response()->json(['error' => 'Image upload failed'], 400);
    }

    public function getProducts(Request $request)
    {
        $products = $this->productService->getProducts($request);

        return response()->json($products);
    }

    public function getProductInfo(Request $request)
    {

        $order = Order::with('items.product')->find($request->order_id);
        $selected_ids = $request->selected_ids ?? [];
        $items_id = [];
        $product_ids = $request->product_ids ?? [];
        $amounts = $request->amounts ?? [];
        $remove_ids= [];

        //lấy ra những product_id của item nằm trong selected_ids
        if ($order) {
            foreach ($order->items as $item) {
                if (in_array($item->product_id, $selected_ids)) {
                    $items_id[] = $item->product_id;
                }
            }
        }

        //lấy những sản phẩm còn lại có id không nằm trong $items_id
        $products_selected_id = [];
        foreach ($selected_ids as $id) {
            if (!in_array($id, $items_id)) {
                $products_selected_id[] = $id;
            }
        }

        $products_selected = Product::with('thumbnail')->whereIn('id', $products_selected_id)->where('stock', '!=', '0')->get();

        $remove_ids = array_diff(array_diff($selected_ids, $items_id), $products_selected->pluck('id')->toArray());

        $table_update = view('admin.order.table-update', ['order' => $order, 'items_id' => $items_id, 'products_selected' => $products_selected, 'product_ids' => $product_ids, 'amounts' => $amounts])->render();

        return response()->json(['table_update' => $table_update, 'remove_ids' => $remove_ids]);
    }
}
