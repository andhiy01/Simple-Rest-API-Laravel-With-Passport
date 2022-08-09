<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'name' => 'required|string|unique:products,name',
            'category_id' => 'required|exists:categories,id',
            'image' => 'required|image|mimes:jpg,png,jpeg|max:2048',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
        ];

        if (in_array($this->method(), ['PUT', 'PATCH'])) {
            $id = $this->product->id;

            $rules['name'] = [
                'required',
                "unique:products,name,{$id},id",
            ];

            $rules['image'] = [
                'image',
                'mimes:jpg,png,jpeg',
                'max:2048'
            ];
        }

        return $rules;
    }
}
