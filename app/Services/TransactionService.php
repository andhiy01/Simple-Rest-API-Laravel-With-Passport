<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\PaymentMethod;
use App\Models\User;
use App\Models\Transaction;
use App\Models\TransactionProduct;
use Illuminate\Support\Facades\Storage;

class TransactionService
{
    public function getAllTransactionByUser()
    {
        /**
         * get all transaction
         *
         * 
         *
         * @return \App\Models\Transaction
         */
        $transaction = Transaction::with('transaction_product.cart.product.category', 'payment_method')->paginate(10);

        return $transaction;
    }

    public function addTransactionByUser(array $data)
    {
        /**
         * add new transaction
         *
         * @param array $data
         *
         * @return \App\Models\Transaction
         */
        $cart = Cart::findOrFail($data['cart_id']);
        $payment_method = PaymentMethod::findOrFail($data['payment_method_id']);

        $transaction = Transaction::create([
            'user_id'           => auth()->id(),
            'transaction_code'  => 'TR-' . date("d-m-Y") . '-0001',
            'payment_code'      => 'ALFAHJAGDUJ',
            'payment_method_id' => $data['payment_method_id'],
            'amount_due'        => $cart->price + $payment_method->admin_fee,
        ]);
        $transaction_product = TransactionProduct::create([
            'transaction_id'    => $transaction->id,
            'cart_id'           => $data['cart_id']
        ]);

        if ($transaction) {
            $cart->status = 'process';
            $cart->save();
        }

        return $transaction->loadMissing('transaction_product.cart.product.category', 'payment_method');
    }

    public function updatePaidTransaction(array $data, $transaction)
    {
        /**
         * edit data transaction
         *
         * @param array $data
         * @param array $transaction
         *
         * @return \App\Models\Transaction
         */
        $transaction->update([
            'image_receipt' => $data['image_receipt'],
            'status' => 'Payment Accepted'
        ]);
        if ($transaction) {
            foreach ($transaction->transaction_product as $key => $value) {
                $value->cart->status = 'success checkout';
                $value->cart->save();
            }
        }


        return $transaction->loadMissing('transaction_product.cart');
    }
}
