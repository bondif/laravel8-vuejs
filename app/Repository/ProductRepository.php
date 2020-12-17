<?php


namespace App\Repository;


use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class ProductRepository
{
    public function all()
    {
        return Product::all();
    }

    public function allByCategory($categoryId)
    {
        return Product::query()
            ->whereHas('categories', function (Builder $query) use ($categoryId) {
                $query->where('categories.id', $categoryId);
            })->get();
    }

    public function save(Product $product, ...$categoryIds): Product
    {
        $createdProduct = null;

        DB::transaction(function () use (&$createdProduct, $product, $categoryIds) {
            $createdProduct = Product::create($product->toArray());
            $createdProduct->categories()->sync($categoryIds);
        });

        return $createdProduct;
    }

    public function delete(Product $product): bool
    {
        $result = false;

        DB::transaction(function () use (&$result, $product) {
            $product->categories()->detach();
            $result = Product::destroy($product->getKey());
        });

        return $result;
    }
}
