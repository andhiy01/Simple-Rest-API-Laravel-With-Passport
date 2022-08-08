<?php

namespace App\Http\Controllers\Api;

use App\Models\Cart;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Services\TransactionService;
use App\Http\Requests\TransactionRequest;
use App\Http\Controllers\Api\ApiController;

class TransactionController extends ApiController
{
    protected $transactionService, $cart, $paymentMethod;

    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
        $this->cart = new Cart();
        $this->paymentMethod = new PaymentMethod();
    }

    public function index()
    {
        try {
            $transaction = $this->transactionService->getAllTransactionByUser();
            if ($transaction->count() == 0)
                return $this->sendSuccess($transaction, 'No Data Found');
            return $this->sendSuccess($transaction, "Success");
        } catch (\Throwable $e) {
            return $this->sendError($e->getMessage());
        }
    }


    public function store(TransactionRequest $request)
    {
        try {
            \DB::beginTransaction();
            $store = $this->transactionService->addTransactionByUser($request->all());
            \DB::commit();
            return $this->sendSuccess($store, "Success Add New Data Transaction");
        } catch (\Throwable $e) {
            \DB::rollback();
            return $this->sendError($e->getMessage());
        }
    }

    public function update(TransactionRequest $request, Transaction $transaction)
    {
        try {
            \DB::beginTransaction();
            $data = $request->only('image_receipt');
            $data = \array_merge($data, [
                'image_receipt' => $request->file('image_receipt')->store('receipt_image')
            ]);
            $update = $this->transactionService->updatePaidTransaction($data, $transaction);
            \DB::commit();
            return $this->sendSuccess($update, "Successfully uploaded proof of payment");
        } catch (\Throwable $e) {
            \DB::rollback();
            return $this->sendError($e->getMessage());
        }
    }

    public function destroy(Transaction $transaction)
    {
        //
    }
}
