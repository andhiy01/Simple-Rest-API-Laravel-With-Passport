<?php

namespace App\Services;

use App\Models\PaymentMethod;

class PaymentMethodService
{
    public function getAllPaymentMethod()
    {
        /**
         * get all payment method
         *
         * 
         *
         * @return \App\Models\PaymentMethod
         */
        $paymen_method = PaymentMethod::paginate(10);

        return $paymen_method;
    }

    public function addPaymentMethod(array $data)
    {
        /**
         * add new PaymentMethod
         *
         * @param array $data
         *
         * @return \App\Models\PaymentMethod
         */

        $paymen_method = PaymentMethod::create($data);

        return $paymen_method;
    }

    public function updatePaymentMethod(array $data, $payment_method)
    {
        /**
         * edit dataPaymentMethod
         *
         * @param array $data
         * @param array $payment_method
         *
         * @return \App\Models\PaymentMethod
         */

        $payment_method->update($data);

        return $payment_method;
    }

    public function deletePaymentMethod($paymen_method)
    {
        $paymen_method->delete();
        return $paymen_method;
    }

    public function getSearchPaymentMethod(string $search = null)
    {
        /**
         * get PaymentMethod data by name
         *
         * @param string $search
         *
         * @return \App\Models\PaymentMethod
         */
        $paymen_method = PaymentMethod::where('name', 'like', '%' . $search . '%')
            ->paginate(10);

        return $paymen_method;
    }
}
