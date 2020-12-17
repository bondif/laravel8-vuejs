<?php

namespace App\Services;

use App\Exceptions\CannotSortWithColumnException;
use App\Exceptions\MaxCategoriesExceededException;
use App\Models\Product;
use App\Repository\ProductRepository;

class ProductService
{
    private $repository;

    private const MAX_CATEGORIES = 2;

    private $sortByColumns = [
        'name',
        'price'
    ];

    public function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
    }

    public function all($category = null, $sortBy = null)
    {
        if ($sortBy && !in_array($sortBy, $this->sortByColumns)) {
            throw new CannotSortWithColumnException();
        }

        return $this->repository->all($category, $sortBy);
    }

    public function store(string $name, string $description, $price, string $image, ...$categoryIds)
    {
        $product = new Product();
        $product->name = $name;
        $product->description = $description;
        $product->price = $price;
        $product->image = $image;

        if (count($categoryIds) > self::MAX_CATEGORIES) {
            throw new MaxCategoriesExceededException();
        }

        return $this->repository->save($product, ...$categoryIds);
    }

    public function destroy($id)
    {
        $product = new Product();
        $product->id = $id;

        return $this->repository->delete($product);
    }
}
