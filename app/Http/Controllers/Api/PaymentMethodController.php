<?php

namespace App\Http\Controllers\Api;

use App\Models\PaymentMethod;
use App\Services\PaymentMethodService;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\PaymentMethodRequest;

class PaymentMethodController extends ApiController
{
    protected $paymentMethodService;

    public function __construct(PaymentMethodService $paymentMethodService)
    {
        $this->paymentMethodService = $paymentMethodService;
    }

    public function index()
    {
        try {
            $payment_method = $this->paymentMethodService->getAllPaymentMethod();
            if ($payment_method->count() == 0)
                return $this->sendSuccess($payment_method, 'No Data Found');
            return $this->sendSuccess($payment_method, "Success");
        } catch (\Throwable $e) {
            return $this->sendError($e->getMessage());
        }
    }


    public function store(PaymentMethodRequest $request)
    {
        try {
            $store = $this->paymentMethodService->addPaymentMethod($request->all());
            return $this->sendSuccess($store, "Success Add New Data Payment Method");
        } catch (\Throwable $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function update(PaymentMethodRequest $request, PaymentMethod $payment_method)
    {
        try {
            $update = $this->paymentMethodService->updatePaymentMethod($request->all(), $payment_method);
            return $this->sendSuccess($update, "Success Update Data Payment Method");
        } catch (\Throwable $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function destroy(PaymentMethod $payment_method)
    {
        try {
            $delete = $this->paymentMethodService->deletePaymentMethod($payment_method);
            return $this->sendSuccess($delete, "Success Delete Data Payment Method");
        } catch (\Throwable $e) {
            return $this->sendError($e->getMessage());
        }
    }
}
