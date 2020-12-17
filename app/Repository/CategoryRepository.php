<?php


namespace App\Repository;


use App\Models\Category;
use Illuminate\Support\Facades\DB;

class CategoryRepository
{
    public function all()
    {
        return Category::all();
    }

    public function save(Category $category): Category
    {
        return Category::create($category->toArray());
    }

    public function delete(Category $category): bool
    {
        $result = false;

        DB::transaction(function () use (&$result, $category) {
            $category->products()->detach();
            $result = Category::destroy($category->getKey());
        });

        return $result;
    }
}
