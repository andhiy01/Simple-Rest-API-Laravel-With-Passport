<?php

namespace App\Services;

use App\Models\Cart;
use App\Exceptions\CustomException;

class CartService
{
    public function getAllCartByUser()
    {
        /**
         * get all Cart
         *
         * 
         *
         * @return \App\Models\Cart
         */
        $cart = Cart::with('product.category')->where('user_id', auth()->id())->paginate(10);

        return $cart;
    }

    public function addCartByUser(array $data)
    {
        /**
         * add new Cart
         *
         * @param array $data
         *
         * @return \App\Models\Cart
         */
        if (Cart::whereUserId(auth()->id())->count() > 1)
            throw new CustomException('Sorry, your cart is full. Please delete some products to add more products');

        //check keranjang yang sudah ada berdasarkan user id, product id dan status in cart
        $check_cart = Cart::with('product')->where('user_id', auth()->id())
            ->where('product_id', $data['product_id'])
            ->where('status', 'in cart')
            ->first();

        // jika user menambah keranjang, produk yang sudah ada dikeranjang maka hanya update data quantity dan harga sesuai dengan yang ditambhkan dan mengurangi stock
        if ($check_cart) {
            $check_cart->update([
                'user_id'    => auth()->id(),
                'product_id' => $data['product_id'],
                'status'     => 'in cart',
                'quantity'   => $check_cart->quantity + $data['quantity'],
                'price'      => ($check_cart->product->price * $data['quantity']) + $check_cart->price,
            ]);
            $check_cart->product->update([
                'stock'      => $check_cart->product->stock - $check_cart->quantity
            ]);

            return $check_cart;
        }
        //jika user menambahkan keranjang baru dan mengurangi stock
        $create_cart = Cart::create($data);
        $create_cart->product->update([
            'stock' => $create_cart->product->stock - $create_cart->quantity
        ]);
        return $create_cart->loadMissing('product');
    }

    public function updateQuantityCart(array $data, $cart)
    {
        /**
         * edit data quantity product in Cart
         *
         * @param array $data
         * @param array $cart
         *
         * @return \App\Models\Cart
         */
        if ($cart->quantity + $cart->product->stock < $data['quantity'])
            throw new CustomException('Sorry, Stock out of range');

        $cart->product->update([
            'stock' => ($cart->product->stock + $cart->quantity) - $data['quantity']
        ]);

        $cart->update([
            'quantity'   => $data['quantity'],
            'price'      => $cart->product->price * $data['quantity']
        ]);

        return $cart->loadMissing('product');
    }

    public function deleteCartById($cart)
    {
        $cart->delete();
        $cart->product->update([
            'stock' => $cart->product->stock + $cart->quantity
        ]);
        return $cart;
    }
}
