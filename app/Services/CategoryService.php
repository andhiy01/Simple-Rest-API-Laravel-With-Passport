<?php

namespace App\Services;

use App\Models\Category;

class CategoryService
{
    public function getAllCategory()
    {
        /**
         * get all Category
         *
         * 
         *
         * @return \App\Models\Category
         */
        $category = Category::all();

        return $category;
    }

    public function addCategory(array $data)
    {
        /**
         * add new category
         *
         * @param array $data
         *
         * @return \App\Models\Category
         */

        $category = Category::create($data);

        return $category;
    }

    public function updateCategory(array $data, $category)
    {
        /**
         * edit data category
         *
         * @param array $data
         * @param array $category
         *
         * @return \App\Models\Category
         */

        $category->update($data);

        return $category;
    }

    public function getSearchCategory(string $search)
    {
        /**
         * get category data by name or email
         *
         * @param string $search
         *
         * @return \App\Models\Category
         */
        $category = Category::where('name', 'like', '%' . $search . '%')
            ->get();

        return $category;
    }
}
