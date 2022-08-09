<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CartRequest extends FormRequest
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
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|numeric|min:1',
            'price' => 'required|numeric',
        ];

        if (in_array($this->method(), ['PUT', 'PATCH'])) {

            $rules['product_id'] = [
                'exists:products,id'
            ];

            $rules['price'] = [
                'numeric'
            ];
        }

        return $rules;
    }
}
