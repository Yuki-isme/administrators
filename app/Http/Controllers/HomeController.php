<?php

namespace App\Http\Controllers;

use App\Services\HomeService;
use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
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

        return view('frontend.home.index', ['newProducts' => $newProducts, 'categories' => $categories, 'brands' => $brands, 'categoriesIndex' => $categoriesIndex]);
    }

    public function productDetail($id)
    {
        $productDetail = $this->homeService->getProductDetail($id);

        return view('frontend.product.detail', ['productDetail' => $productDetail]);
    }

    public function list()
    {
        $products = $this->homeService->getProducts();
        $categories = $this->homeService->getCategories();
        $brands = $this->homeService->getBrands();

        return view('frontend.product.list', ['products' => $products, 'brands' => $brands, 'categories' => $categories]);
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

        $html = view('frontend.product.products', ['newProducts' => $newProducts])->render();

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

        return view('frontend.product.list', ['products' => $products, 'brands' => $brands, 'categories' => $categories, 'category_check' => $id]);
    }

    public function listByBrand($id)
    {
        $products = Product::where('brand_id', $id)->get();

        $categories = $this->homeService->getCategories();
        $brands = $this->homeService->getBrands();

        return view('frontend.product.list', ['products' => $products, 'brands' => $brands, 'categories' => $categories, 'brand_check' => $id]);
    }

    public function myAccount()
    {
        $user = Auth::guard('web')->user();
        $orders = Order::with('items', 'province', 'district', 'ward', 'status')->where('user_id', $user->id)->get();

        return view('frontend.user.account', ['user' => $user, 'orders' => $orders]);
    }

    public function wishlist()
    {
        return view('frontend.user.wishlist');
    }
}
