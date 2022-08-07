<?php

namespace App\Http\Controllers\Api;

use App\Models\Cart;
use Illuminate\Http\Request;
use App\Services\CartService;
use App\Http\Controllers\Api\ApiController;

class CartController extends ApiController
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index()
    {
        try {
            $cart = $this->cartService->getAllCartByUser();
            if ($cart->count() == 0)
                return $this->sendSuccess($cart, 'No Data Found');
            return $this->sendSuccess($cart, "Success");
        } catch (\Throwable $e) {
            return $this->sendError($e->getMessage());
        }
    }


    public function store(Request $request)
    {
        try {
            \DB::beginTransaction();
            $data = \array_merge($request->all(), [
                'user_id' => auth()->id(),
            ]);
            $store = $this->cartService->addCartByUser($data);
            \DB::commit();
            return $this->sendSuccess($store, "Success Add New Data Cart");
        } catch (\Throwable $e) {
            \DB::rollback();
            return $this->sendError($e->getMessage());
        }
    }

    public function update(Request $request, Cart $cart)
    {
        try {
            \DB::beginTransaction();
            $update = $this->cartService->updateQuantityCart($request->all(), $cart);
            \DB::commit();
            return $this->sendSuccess($update, "Success Update Data Quantity Product in Cart");
        } catch (\Throwable $e) {
            \DB::rollback();
            return $this->sendError($e->getMessage());
        }
    }

    public function destroy(Cart $cart)
    {
        try {
            $delete = $this->cartService->deleteCartById($cart);
            return $this->sendSuccess($delete, "Success Delete Data Cart");
        } catch (\Throwable $e) {
            return $this->sendError($e->getMessage());
        }
    }
}
