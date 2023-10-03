<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CartService;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use Illuminate\Support\Facades\DB;


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

        if ($check == 'amount') {
            return response()->json(['success' => false, 'message' => 'So luong san pham khong du']);
        } else if ($check == 'stock') {
            return response()->json(['success' => false, 'message' => 'San pham da het hang']);
        } else {
            $discount = $this->cartService->getDiscount();
            $wishlists = Auth::guard('web')->check() ?  Auth::guard('web')->user()->wishlists->pluck('id')->toArray() : null;
            $cart = view('frontend.checkout.update.cart', ['wishlists' => $wishlists])->render();
            $total = view('frontend.checkout.update.total', ['total' => $this->cartService->getTotal(), 'discount' => $discount])->render();
            return response()->json(['success' => true, 'message' => 'Them thanh cong', 'count' => count(cart()->getContent()), 'cart' => $cart, 'total' => $total]);
        }
    }

    public function index()
    {

        $wishlists = Auth::guard('web')->check() ?  Auth::guard('web')->user()->wishlists->pluck('id')->toArray() : null;

        $carts = cart()->getContent();
        $similar = collect([]);

        if ($carts) {
            foreach ($carts as $product_id => $item) {
                $similarProduct = Product::with('thumbnail')
                    ->join('product_tag', 'products.id', '=', 'product_tag.product_id')
                    ->join('tags', 'product_tag.tag_id', '=', 'tags.id')
                    ->select('products.id', DB::raw('MAX(products.name) as product_name'), DB::raw('COUNT(tags.id) as tag_count'))
                    ->where('products.id', '!=', $product_id)
                    ->whereIn('tags.id', function ($query) use ($product_id) {
                        $query->select('tag_id')
                            ->from('product_tag')
                            ->where('product_id', $product_id);
                    })
                    ->where('products.stock', '>', 0)
                    ->groupBy('products.id')
                    ->orderByDesc('tag_count')
                    ->take(1)
                    ->get();

                if ($similarProduct->isNotEmpty()) {
                    $similar = $similar->concat($similarProduct);
                }
            }
        }
        // Kiểm tra nếu $similar chưa đủ 4 sản phẩm thì lấy sản phẩm mới nhất
        if ($similar->count() < 4) {
            $newestProducts = Product::with('thumbnail')
                ->where('stock', '>', 0)
                ->orderBy('created_at', 'desc')
                ->take(4 - $similar->count())
                ->get(); // Chuyển đổi kết quả thành Collection

            $similar = $similar->concat($newestProducts);
        }



        return view('frontend.checkout.cart', ['carts' => $carts, 'wishlists' => $wishlists, 'similar' => $similar]);
    }

    public function deleteItem($id)
    {
        $this->cartService->remove($id);
        $discount = $this->cartService->getDiscount();
        $wishlists = Auth::guard('web')->check() ?  Auth::guard('web')->user()->wishlists->pluck('id')->toArray() : null;

        $cart = view('frontend.checkout.update.cart', ['wishlists' => $wishlists])->render();
        $total = view('frontend.checkout.update.total', ['total' => $this->cartService->getTotal(), 'discount' => $discount])->render();

        return response()->json(['count' => count(cart()->getContent()), 'cart' => $cart, 'total' => $total]);
    }

    public function updateAmount($id, Request  $request)
    {
        $amount = $request->amount;
        $wishlists = Auth::guard('web')->check() ?  Auth::guard('web')->user()->wishlists->pluck('id')->toArray() : null;
        if ($amount <= 0) {
            return response()->json(['success' => false, 'message' => 'Số lượng sản phẩm không hợp lệ.']);
        }

        $this->cartService->updateAmount($id, $amount);
        $discount = $this->cartService->getDiscount();
        $cart = view('frontend.checkout.update.cart', ['wishlists' => $wishlists])->render();
        $total = view('frontend.checkout.update.total', ['total' => $this->cartService->getTotal(), 'discount' => $discount])->render();

        return response()->json(['count' => count(cart()->getContent()), 'cart' => $cart, 'total' => $total]);
    }

    public function reorder(Request $request)
    {
        return $this->cartService->reorder($request->order_id);
    }
}
