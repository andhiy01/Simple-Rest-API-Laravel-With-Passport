<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Services\CategoryService;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\ApiController;

class CategorySearchController extends ApiController
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function __invoke(Request $request)
    {
        try {
            $category =  $this->categoryService->getSearchCategory($request->search);

            // $check = AuthenticationService::checkVerification($category, $category);
            if ($category->count() == 0)
                return $this->sendError('Data Not Found', Response::HTTP_NO_CONTENT);
            // $message = $category->count() == 0 ? "category Not Found" : "Success Found Data";

            return $this->sendSuccess($category, 'Success Found Data');
        } catch (\Throwable $e) {
            return $this->sendError($e->getMessage());
        }
    }
}
