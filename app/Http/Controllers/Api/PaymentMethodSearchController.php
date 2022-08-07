<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Services\PaymentMethodService;
use App\Http\Controllers\Api\ApiController;

class PaymentMethodSearchController extends ApiController
{
    protected $paymentMethodService;

    public function __construct(PaymentMethodService $paymentMethodService)
    {
        $this->paymentMethodService = $paymentMethodService;
    }

    public function __invoke(Request $request)
    {
        try {
            $paymentMethod =  $this->paymentMethodService->getSearchPaymentMethod($request->search);

            if ($paymentMethod->count() == 0)
                return $this->sendError('Data Not Found', Response::HTTP_NO_CONTENT);

            return $this->sendSuccess($paymentMethod, 'Success Found Data');
        } catch (\Throwable $e) {
            return $this->sendError($e->getMessage());
        }
    }
}
