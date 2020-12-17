<?php


namespace App\Repository;


use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class ProductRepository
{
    public function all($categoryId = null, $orderByColumn = null)
    {
        return Product::query()
            ->when($categoryId, function (Builder $query) use ($categoryId) {
                $query->whereHas('categories', function (Builder $query) use ($categoryId) {
                    $query->where('categories.id', $categoryId);
                });
            })
            ->when($orderByColumn, function (Builder $query) use ($orderByColumn) {
                $query->orderBy($orderByColumn);
            })
            ->get();
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
