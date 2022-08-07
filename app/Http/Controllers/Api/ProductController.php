<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Services\ProductService;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Api\ApiController;

class ProductController extends ApiController
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index()
    {
        try {
            $product =  $this->productService->getAllProduct();

            // $check = AuthenticationService::checkVerification($product, $product);
            // if ($check)
            //     return $this->sendError($check['message'], $check['code'], $check['data']);


            return $this->sendSuccess($product, "Success ");
        } catch (\Throwable $e) {
            return $this->sendError($e->getMessage());
        }
    }


    public function store(ProductRequest $request)
    {
        try {
            $data = $request->except('image');
            $data = \array_merge($data, [
                'image' => $request->file('image')->store('product_image')
            ]);
            $store = $this->productService->addProduct($data);
            return $this->sendSuccess($store, "Success Add New Data product");
        } catch (\Throwable $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }




    public function update(ProductRequest $request, Product $product)
    {
        try {
            $data = $request->except('image');
            $old_image = $product->image;
            if ($request->file('image')) {
                $data = \array_merge($data, [
                    'image' => $request->file('image')->store('product_image')
                ]);
            }

            $update = $this->productService->updateProduct($data, $product);

            if ($update && $request->file('image')) {
                Storage::delete($old_image);
            }
            return $this->sendSuccess($update, "Success Update Data Product");
        } catch (\Throwable $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        try {
            $delete = $this->productService->deleteProduct($product);
            return $this->sendSuccess($delete, "Success Delete Data Product");
        } catch (\Throwable $e) {
            return $this->sendError($e->getMessage());
        }
    }
}
