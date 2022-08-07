<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Services\ProductService;
use App\Http\Controllers\Controller;
use App\Services\AuthenticationService;
use App\Http\Controllers\Api\ApiController;

class ProductSearchController extends ApiController
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function __invoke(Request $request)
    {
        try {
            $product =  $this->productService->getSearchProduct($request->search);

            // $check = AuthenticationService::checkVerification($product, $product);
            if ($product->count() == 0)
                return $this->sendError('Data Not Found', Response::HTTP_NO_CONTENT);
            // $message = $product->count() == 0 ? "product Not Found" : "Success Found Data";

            return $this->sendSuccess($product, 'Success Found Data');
        } catch (\Throwable $e) {
            return $this->sendError($e->getMessage());
        }
    }
}
