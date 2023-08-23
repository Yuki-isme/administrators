<?php

namespace App\Services;

use App\Exceptions\CommonException;
use App\Repositories\ProductRepository;

class CartService
{
    private $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function add($id, $request)
    {

        $product = $this->productRepository->getById($id);

        if (!$product) {
            throw new CommonException();
        }
        if ($request->amount && $request->amount > $product->stock) {
            throw new CommonException('So luong san pham khong du');
        }

        $cart = session()->get('cart');

        if (isset($cart[$id])) {
            $cart[$id]['amount'] += $request->amount ?? 1;
        } else {
            $cart[$id] = [
                'id' => $id,
                'name' => $product->name,
                'price' => $product->cart_price,
                'amount' => $request->amount ?? 1,
                'img' => $product->thumbnail->url,
            ];
        }


        session()->put('cart', $cart);

        return redirect()->back();
    }


    public function remove($id)
    {
        $cart = session()->get('cart');

        unset($cart[$id]);

        return session()->push('cart', $cart);
    }

    public function destroy()
    {
        return session()->forget('cart');
    }

    public function getContent()
    {
        return session()->get('cart');
    }

    public function getTotal()
    {

        $total = 0;

        if(session()->has('cart')){
            $cart = session()->get('cart');
            foreach ($cart as $item) {
                $total += $item['amount'] * $item['price'];
            }
        }

        return $total;
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
            foreach (session()->get('cart') as $cart) {
                $products[$cart['id']] = [
                    'price' => $this->productRepository->getPriceProduct($cart['id']),
                    'stock' => $this->productRepository->getStockProduct($cart['id']),
                ];
            }
        }

        return $products;
    }
}
