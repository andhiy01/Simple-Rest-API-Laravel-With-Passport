<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Services\CategoryService;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Controllers\Api\ApiController;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class CategoryController extends ApiController
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        try {
            $category =  $this->categoryService->getAllCategory();

            if ($category->count() == 0)
                return $this->sendError('No Data Found', Response::HTTP_NO_CONTENT);

            return $this->sendSuccess($category, "Data Successfully Displayed");
        } catch (\Throwable $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function store(CategoryRequest $request)
    {
        try {
            $data = $request->except('image');
            $data = \array_merge($data, [
                'image' => $request->file('image')->store('category_image')
            ]);

            $store = $this->categoryService->addcategory($data);
            return $this->sendSuccess($store, "Success Add New Category");
        } catch (\Throwable $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function update(CategoryRequest $request, Category $category)
    {
        try {
            $data = $request->except('image');
            $old_image = $category->image;
            if ($request->file('image')) {
                $data = \array_merge($data, [
                    'image' => $request->file('image')->store('category_image')
                ]);
            }

            $update = $this->categoryService->updateCategory($data, $category);

            if ($update && $request->file('image')) {
                Storage::delete($old_image);
            }
            return $this->sendSuccess($update, "Success Update Data category");
        } catch (\Throwable $e) {
            return $this->sendError($e->getMessage());
        }
    }
}
