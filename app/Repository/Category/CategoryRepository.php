<?php


namespace App\Repository\Category;


use App\Models\Category\Category;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class CategoryRepository
{
    public function all(): Collection
    {
        return Category::all();
    }

    public function save(string $name, int $parentId = null): Category
    {
        $category = compact('name', 'parentId');

        return Category::create($category);
    }

    public function find(int $categoryId): Category
    {
        return Category::findOrFail($categoryId);
    }

    public function delete(int $categoryId): bool
    {
        $result = false;

        $category = Category::query()->findOrFail($categoryId);

        DB::transaction(function () use (&$result, $category) {
            $category->products()->detach();
            $result = Category::destroy($category->getKey()) > 0;
        });

        return $result;
    }
}
