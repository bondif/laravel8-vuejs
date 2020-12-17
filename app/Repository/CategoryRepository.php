<?php


namespace App\Repository;


use App\Models\Category;

class CategoryRepository
{
    public function save(Category $category): Category
    {
        return Category::create($category->toArray());
    }
}