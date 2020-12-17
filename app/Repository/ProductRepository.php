<?php


namespace App\Repository;


use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductRepository
{
    public function save(Product $product, ...$categoryIds): Product
    {
        $createdProduct = null;

        DB::transaction(function () use (&$createdProduct, $product, $categoryIds) {
            $createdProduct = Product::create($product->toArray());
            $createdProduct->categories()->sync($categoryIds);
        });

        return $createdProduct;
    }
}
