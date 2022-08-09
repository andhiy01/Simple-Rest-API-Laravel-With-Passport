<?php

namespace App\Services;

use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ProductService
{
    public function getAllProduct()
    {
        /**
         * get all product
         *
         * 
         *
         * @return \App\Models\Product
         */
        $product = Product::with('category')->paginate(10);

        return $product;
    }

    public function addProduct(array $data)
    {
        /**
         * add new product
         *
         * @param array $data
         *
         * @return \App\Models\Product
         */

        $product = Product::create($data);

        return $product->loadMissing('category');
    }

    public function updateProduct(array $data, $product)
    {
        /**
         * edit data product
         *
         * @param array $data
         * @param array $product
         *
         * @return \App\Models\Product
         */

        $product->update($data);

        return $product->loadMissing('category');
    }

    public function deleteProduct($product)
    {
        $product->delete();
        Storage::delete($product->image);

        return $product->loadMissing('category');
    }

    public function getSearchProduct(string $search)
    {
        /**
         * get Product data by name or email
         *
         * @param string $search
         *
         * @return \App\Models\Product
         */
        $product = Product::where('name', 'like', '%' . $search . '%')
            ->paginate(10);

        return $product;
    }
}
