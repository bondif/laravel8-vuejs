<?php


namespace App\Repository\Product;


use App\Models\Product\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class ProductRepository
{
    public function all($categoryId = null, $orderByColumn = null): Collection
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

    public function save(string $name, string $description, float $price, string $image, ...$categoryIds): Product
    {
        $createdProduct = null;

        $product = compact('name', 'description', 'price', 'image');

        DB::transaction(function () use (&$createdProduct, $product, $categoryIds) {
            $createdProduct = Product::create($product);
            $createdProduct->categories()->sync($categoryIds);
        });

        return $createdProduct;
    }

    public function delete(int $productId): bool
    {
        $result = false;

        $product = Product::query()->findOrFail($productId);

        DB::transaction(function () use (&$result, $product) {
            $product->categories()->detach();
            $result = Product::destroy($product->getKey()) > 0;
        });

        return $result;
    }

    public function getCategoriesAsString(int $productId): string
    {
        return Product::query()
            ->findOrFail($productId)
            ->categories()
            ->get(['name'])
            ->map(function ($category) {
                return $category->name;
            })
            ->implode(', ');
    }
}
