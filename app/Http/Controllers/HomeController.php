<?php

namespace App\Http\Controllers;

use App\Services\HomeService;
use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    private $homeService;

    public function __construct(HomeService $homeService)
    {
        $this->homeService = $homeService;
    }

    public function index($limit = 8)
    {
        $newProducts = $this->homeService->getNewProducts($limit);
        $categories = $this->homeService->getCategory();
        $brands = $this->homeService->getBrand();
        $categoriesIndex = $this->homeService->getCategoriesIndex();
        $wishlists = Auth::guard('web')->check() ?  Auth::guard('web')->user()->wishlists->pluck('id')->toArray() : null;

        return view('frontend.home.index', ['newProducts' => $newProducts, 'categories' => $categories, 'brands' => $brands, 'categoriesIndex' => $categoriesIndex, 'wishlists' => $wishlists]);
    }

    public function productDetail($id)
    {
        $productDetail = $this->homeService->getProductDetail($id);
        $wishlists = Auth::guard('web')->check() ?  Auth::guard('web')->user()->wishlists->pluck('id')->toArray() : null;
        $similarProducts = Product::where('id', '!=', $id) // Loại trừ sản phẩm đang xem xét.
            ->orderByRaw('CASE WHEN id IN (
        SELECT pt.product_id
        FROM product_tag pt
        WHERE pt.tag_id IN (
            SELECT tag_id
            FROM product_tag
            WHERE product_id = ?)
    ) THEN 0 ELSE 1 END, created_at DESC', [$id])
            ->with('thumbnail') // Load quan hệ thumbnail.
            ->limit(10)
            ->get();


        return view('frontend.product.detail', ['productDetail' => $productDetail, 'similarProducts' => $similarProducts, 'wishlists' => $wishlists]);
    }

    public function list()
    {
        $products = $this->homeService->getProducts();
        $categories = $this->homeService->getCategories();
        $brands = $this->homeService->getBrands();
        $wishlists = Auth::guard('web')->check() ?  Auth::guard('web')->user()->wishlists->pluck('id')->toArray() : null;

        return view('frontend.product.list', ['products' => $products, 'brands' => $brands, 'categories' => $categories, 'wishlists' => $wishlists]);
    }

    public function browseTrees($parent)
    {
        $leafCategories = [];

        if ($parent->child->isEmpty()) {
            // Nếu không có con nào, trả về category hiện tại
            $leafCategories[] = $parent;
        } else {
            // Nếu có con, lặp qua từng con và thực hiện đệ quy
            foreach ($parent->child as $child) {
                $leafCategories = array_merge($leafCategories, $this->browseTrees($child));
            }
        }

        return $leafCategories;
    }

    public function listByCategoryBrand(Request $request)
    {
        $products = Product::query();

        if ($request->brand_id) {
            $products->where('brand_id', $request->brand_id);
        }

        if ($request->category_id) {
            $category = Category::find($request->category_id);
            $leafCategories = $this->browseTrees($category);
            $categoryIds = collect($leafCategories)->pluck('id')->toArray();
            $products->whereIn('category_id', $categoryIds);
        }

        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');

        // Kiểm tra nếu cả hai giá trị min và max đều tồn tại
        if ($minPrice !== null && $maxPrice !== null) {
            $products->whereRaw('IF(sale_price > 0, sale_price, price) BETWEEN ? AND ?', [$minPrice, $maxPrice]);
        } elseif ($minPrice !== null) {
            // Kiểm tra nếu chỉ có giá trị min tồn tại
            $products->whereRaw('IF(sale_price > 0, sale_price, price) >= ?', [$minPrice]);
        } elseif ($maxPrice !== null) {
            // Kiểm tra nếu chỉ có giá trị max tồn tại
            $products->whereRaw('IF(sale_price > 0, sale_price, price) <= ?', [$maxPrice]);
        }

        if ($request->sort_option === 'latest') {
            // Sắp xếp theo ID từ cao đến thấp (Latest)
            $products->orderBy('id', 'desc');
        } elseif ($request->sort_option === 'oldest') {
            // Sắp xếp theo ID từ thấp đến cao (Oldest)
            $products->orderBy('id', 'asc');
        } elseif ($request->sort_option == 'price_asc') {
            $products->orderByRaw('IF(sale_price > 0, sale_price, price) ASC');
        } elseif ($request->sort_option == 'price_desc') {
            $products->orderByRaw('IF(sale_price > 0, sale_price, price) DESC');
        }

        $newProducts = $products->get();
        $wishlists = Auth::guard('web')->check() ?  Auth::guard('web')->user()->wishlists->pluck('id')->toArray() : null;

        $html = view('frontend.product.products', ['newProducts' => $newProducts, 'wishlists' => $wishlists])->render();

        return response()->json(['html' => $html, 'count' => count($newProducts)]);
    }

    public function listByCategory($id)
    {
        $category = Category::find($id);
        $leafCategories = $this->browseTrees($category);
        $categoryIds = collect($leafCategories)->pluck('id')->toArray();
        $products = Product::whereIn('category_id', $categoryIds)->get();

        $categories = $this->homeService->getCategories();
        $brands = $this->homeService->getBrands();
        $wishlists = Auth::guard('web')->check() ?  Auth::guard('web')->user()->wishlists->pluck('id')->toArray() : null;

        return view('frontend.product.list', ['products' => $products, 'brands' => $brands, 'categories' => $categories, 'category_check' => $id, 'wishlists' => $wishlists]);
    }

    public function listByBrand($id)
    {
        $products = Product::where('brand_id', $id)->get();

        $categories = $this->homeService->getCategories();
        $brands = $this->homeService->getBrands();
        $wishlists = Auth::guard('web')->check() ?  Auth::guard('web')->user()->wishlists->pluck('id')->toArray() : null;

        return view('frontend.product.list', ['products' => $products, 'brands' => $brands, 'categories' => $categories, 'brand_check' => $id, 'wishlists' => $wishlists]);
    }

    public function myAccount()
    {
        $user = Auth::guard('web')->user();
        $orders = Order::with('items', 'province', 'district', 'ward', 'status')->where('user_id', $user->id)->orderByDesc('id')->get();

        return view('frontend.user.account', ['user' => $user, 'orders' => $orders]);
    }

    public function wishlist()
    {

        $products = Auth::guard('web')->user()->wishlists->load('thumbnail', 'tags');
        $wishlists = Auth::guard('web')->check() ?  Auth::guard('web')->user()->wishlists->pluck('id')->toArray() : null;
        $similarProducts = Product::with('thumbnail')
            ->select('products.id', 'products.name', 'products.description', 'products.price', DB::raw('SUM(items.amount) as total_amount'))
            ->join('items', 'products.id', '=', 'items.product_id')
            ->groupBy('products.id', 'products.name', 'products.description', 'products.price')
            ->orderByDesc('total_amount')
            ->take(4)
            ->get();

        // Kiểm tra xem có đủ 10 sản phẩm không
        if ($similarProducts->count() < 4) {
            $remainingCount = 4 - $similarProducts->count();

            // Lấy sản phẩm mới nhất nếu không đủ 10
            $latestProducts = Product::with('thumbnail')
                ->where('stock', '>', 0)
                ->orderByDesc('created_at')
                ->take($remainingCount)
                ->get();

            // Kết hợp danh sách sản phẩm mới nhất với danh sách sản phẩm hàng đầu
            $similarProducts = $similarProducts->concat($latestProducts);
        }

        return view('frontend.user.wishlist', ['products' => $products, 'wishlists' => $wishlists, 'similarProducts' => $similarProducts]);
    }

    public function search(Request $request)
    {
        $query = Product::query()->with('thumbnail');

        if ($request->q) {
            $query->where('name', 'like', "%$request->q%");
        }

        $products = $query->paginate(10);

        return view('frontend.home.search', ['products' => $products])->render();
    }

    public function searchProducts(Request $request)
    {
        $products = Product::where('name', 'like', "%$request->q%")->get();

        $categories = $this->homeService->getCategories();
        $brands = $this->homeService->getBrands();

        return view('frontend.product.list', ['products' => $products, 'brands' => $brands, 'categories' => $categories]);
    }

    public function addWishlist($id, Request $request)
    {
        // Lấy người dùng hiện tại
        $user = $request->user();

        // Lấy sản phẩm cần thêm vào danh sách mong muốn
        $product = Product::find($id);

        if (!$user || !$product) {
            return response()->json(['success' => false, 'message' => 'Không thể thêm sản phẩm vào danh sách mong muốn.']);
        }

        // Kiểm tra xem sản phẩm đã tồn tại trong danh sách mong muốn của người dùng chưa
        if (!$user->wishlists()->where('product_id', $id)->exists()) {
            // Nếu sản phẩm chưa tồn tại, thêm vào danh sách mong muốn
            $user->wishlists()->attach($id);

            return response()->json(['success' => true, 'message' => 'Sản phẩm đã được thêm vào danh sách mong muốn.']);
        }

        return response()->json(['success' => false, 'message' => 'Sản phẩm đã tồn tại trong danh sách mong muốn.']);
    }

    public function wishlistUpdate($id, Request $request)
    {
        $user = $request->user();
        $product = Product::find($id);

        if (!$user || !$product) {
            return response()->json(['success' => false, 'message' => 'Không thể thêm sản phẩm vào danh sách mong muốn.']);
        }

        // Thêm hoặc xóa sản phẩm khỏi danh sách mong muốn
        if (!$user->wishlists()->where('product_id', $id)->exists()) {
            $user->wishlists()->attach($id);
        } else {
            $user->wishlists()->detach($id);
        }

        // Lấy danh sách sản phẩm mới kèm theo thông tin thumbnail và tags
        $products = Auth::guard('web')->user()->wishlists->load('thumbnail', 'tags');
        $wishlists = Auth::guard('web')->check() ?  Auth::guard('web')->user()->wishlists->pluck('id')->toArray() : null;

        // Render view để cập nhật giao diện
        $view = view('frontend.user.wishlist-update', ['products' => $products, 'wishlists' => $wishlists])->render();

        if (!$user->wishlists()->where('product_id', $id)->exists()) {
            return response()->json(['success' => true, 'message' => 'Sản phẩm đã được xóa khỏi danh sách mong muốn.', 'view' => $view]);
        } else {
            return response()->json(['success' => true, 'message' => 'Sản phẩm đã được xóa khỏi danh sách mong muốn.', 'view' => $view]);
        }
    }


    public function removeWishlist($id, Request $request)
    {
        // Lấy người dùng hiện tại
        $user = $request->user();

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Không thể xóa sản phẩm khỏi danh sách mong muốn.']);
        }

        // Xóa sản phẩm khỏi danh sách mong muốn của người dùng
        $user->wishlists()->detach($id);

        return response()->json(['success' => true, 'message' => 'Sản phẩm đã được xóa khỏi danh sách mong muốn.']);
    }

    public function test(Request $request)
    {
        dd($request);
    }
}
