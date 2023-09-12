<?php

namespace App\Services;

use App\Exceptions\CommonException;
use App\Repositories\ProductRepository;
use App\Repositories\CartRepository;
use Illuminate\Support\Facades\Auth;

class CartService
{
    private $productRepository;
    private $cartRepository;

    public function __construct(ProductRepository $productRepository, CartRepository $cartRepository)
    {
        $this->productRepository = $productRepository;
        $this->cartRepository = $cartRepository;
    }

    public function add($id, $request)
    {

        $product = $this->productRepository->getProduct($id);

        if (!$product) {
            throw new CommonException('Product not found!');
        }

        if($request->amount && $request->amout > $product->stock){
            return 'amount';
        }

        if($product->stock == 0){
            return 'stock';
        }

        if (Auth::guard('web')->check()) {
            $user = Auth::guard('web')->user();

            $existingCartItem = $this->cartRepository->query()->where('user_id', $user->id)
                ->where('product_id', $id)
                ->first();

            if ($existingCartItem) {
                // Cập nhật giỏ hàng nếu sản phẩm đã tồn tại
                $existingCartItem->amount += $request->amount ?? 1;
                $existingCartItem->save();
            } else {
                // Tạo mới bản ghi trong bảng cart nếu sản phẩm chưa tồn tại
                $this->cartRepository->create([
                    'user_id' => $user->id,
                    'product_id' => $id,
                    'name' => $product->name,
                    'price' => $product->cart_price,
                    'discount' => $product->price - $product->cart_price,
                    'amount' => $request->amount ?? 1,
                    'img' => $product->thumbnail->url,
                ]);
            }
        } else {
            $cart = session()->get('cart');

            if (isset($cart[$id])) {
                $cart[$id]['amount'] += $request->amount ?? 1;
            } else {
                $cart[$id] = [
                    'name' => $product->name,
                    'price' => $product->cart_price,
                    'discount' => $product->price - $product->cart_price,
                    'amount' => $request->amount ?? 1,
                    'img' => $product->thumbnail->url,
                    'stock' => $product->stock,
                ];
            }

            session()->put('cart', $cart);
        }
    }

    public function updateAmount($id, $amount)
    {
        if (Auth::guard('web')->check()) {
            $user = Auth::guard('web')->user();

            $cartItem = $this->cartRepository->query()->where('user_id', $user->id)
                ->where('product_id', $id)
                ->first();

            if ($cartItem) {
                // Cập nhật số lượng sản phẩm trong giỏ hàng nếu sản phẩm tồn tại
                $cartItem->amount = $amount;
                $cartItem->save();
            }
        } else {
            $cart = session()->get('cart');

            if (isset($cart[$id])) {
                // Cập nhật số lượng sản phẩm trong giỏ hàng nếu sản phẩm tồn tại
                $cart[$id]['amount'] = $amount;
                session()->put('cart', $cart);
            }
        }
    }

    public function remove($id)
    {
        if (Auth::guard('web')->check()) {
            $user = Auth::guard('web')->user();

            $cartItem = $this->cartRepository->query()->where('user_id', $user->id)
                ->where('product_id', $id)
                ->first();

            if ($cartItem) {
                $cartItem->delete();
            }
        } else {
            $cart = session()->get('cart');

            if (isset($cart[$id])) {
                unset($cart[$id]);
                session()->put('cart', $cart);
            }
        }
    }

    public function destroy()
    {
        if (Auth::guard('web')->check()) {
            $user = Auth::guard('web')->user();

            $this->cartRepository->query()->where('user_id', $user->id)->delete();
        } else {
            session()->forget('cart');
        }
    }

    public function getContent()
    {
        $cart = [];

        if (Auth::guard('web')->check()) {
            $user = Auth::guard('web')->user();

            $cartItems = $this->cartRepository->query()->where('user_id', $user->id)->with('product')->get();

            foreach ($cartItems as $cartItem) {
                $product = $cartItem->product;

                $cart[$cartItem->product_id] = [
                    'product_id' => $cartItem->product_id,
                    'name' => $cartItem->name,
                    'price' => $cartItem->price,
                    'discount' => $cartItem->discount,
                    'amount' => $cartItem->amount,
                    'img' => $cartItem->img,
                    'stock' => $product->stock,
                ];
            }
        } else {
            $sessionCart = session()->get('cart');

            if ($sessionCart && count($sessionCart) > 0) {
                foreach ($sessionCart as $productId => $item) {
                    $product = $this->productRepository->getProduct($productId);

                    if ($product) {
                        $item['stock'] = $product->stock;
                    }
                }
            }

            $cart = $sessionCart;
        }

        return $cart;
    }

    public function getTotal()
    {

        $total = 0;

        if (Auth::guard('web')->check()) {
            $user = Auth::guard('web')->user();

            $cartItems = $this->cartRepository->query()->where('user_id', $user->id)->get();

            foreach ($cartItems as $cartItem) {
                $total += $cartItem->amount * $cartItem->price;
            }
        } else {
            if (session()->has('cart') && count(session()->get('cart')) > 0) {
                $cart = session()->get('cart');
                foreach ($cart as $item) {
                    $total += $item['amount'] * $item['price'];
                }
            }
        }

        return $total;
    }

    public function getDiscount()
    {
        $discount = 0;

        if (Auth::guard('web')->check()) {
            $user = Auth::guard('web')->user();

            $cartItems = $this->cartRepository->query()->where('user_id', $user->id)->get();

            foreach ($cartItems as $cartItem) {
                $discount += $cartItem->amount * $cartItem->discount;
            }
        } else {
            if (session()->has('cart') && count(session()->get('cart')) > 0) {
                $cart = session()->get('cart');
                foreach ($cart as $item) {
                    $discount += $item['amount'] * $item['discount'];
                }
            }
        }

        return $discount;
    }

    public function moveCartToDatabase()
    {
        if (Auth::guard('web')->check()) {
            $user = Auth::guard('web')->user();
            $sessionCart = session()->get('cart');

            if ($sessionCart && count($sessionCart) > 0) {
                foreach ($sessionCart as $productId => $item) {
                    $product = $this->productRepository->getProduct($productId);

                    if ($product) {
                        $existingCartItem = $this->cartRepository->query()->where('user_id', $user->id)
                            ->where('product_id', $productId)
                            ->first();

                        if ($existingCartItem) {
                            $existingCartItem->update([
                                'amount' => $existingCartItem->amount += $item['amount']
                            ]);
                        } else {
                            // Tạo mới bản ghi trong bảng cart nếu sản phẩm chưa tồn tại
                            $this->cartRepository->create([
                                'user_id' => $user->id,
                                'product_id' => $productId,
                                'amount' => $item['amount'],
                                'name' => $product->name,
                                'price' => $product->cart_price,
                                'img' => $product->thumbnail->url,
                            ]);
                        }
                    }
                }

                // Xóa giỏ hàng phiên sau khi đã di chuyển vào cơ sở dữ liệu
                session()->forget('cart');
            }
        }
    }

    public function getStockProduct($id_product)
    {
        return $this->productRepository->getStockProduct($id_product);
    }

    public function getPriceProduct($id_product)
    {
        return $this->productRepository->getPriceProduct($id_product);
    }

    public function index()
    {
        $products = [];

        if (session()->has('cart')) {
            foreach (session()->get('cart') as $id => $cart) {
                $products[$id] = [
                    'price' => $this->productRepository->getPriceProduct($id),
                    'stock' => $this->productRepository->getStockProduct($id),
                ];
            }
        }

        return $products;
    }
}
