<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransactionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rules =  [
            'payment_method_id' => 'required|exists:payment_methods,id',
            'cart_id' => 'required|exists:carts,id',
        ];

        if (in_array($this->method(), ['PUT', 'PATCH'])) {
            $rules['payment_method_id'] = [
                'exists:payment_methods,id'
            ];

            $rules['cart_id'] = [
                'exists:carts,id'
            ];

            $rules['image'] = [
                'required',
                'image',
                'mimes:jpg,png,jpeg',
                'max:2048'
            ];
        }

        return $rules;
    }
}
