<?php

namespace App\Services\Product;

use App\Exceptions\CannotSortWithColumnException;
use App\Exceptions\Category\MaxCategoriesExceededException;
use App\Models\Product\Product;
use App\Repository\Product\ProductRepository;
use App\Services\FileUploader;

class ProductService
{
    private $repository;

    private $fileUploader;

    private const MAX_CATEGORIES = 2;

    private $sortByColumns = [
        'name',
        'price'
    ];

    public function __construct(ProductRepository $repository, FileUploader $fileUploader)
    {
        $this->repository = $repository;
        $this->fileUploader = $fileUploader;
    }

    public function all($category = null, $sortBy = null)
    {
        if ($sortBy && !in_array($sortBy, $this->sortByColumns)) {
            throw new CannotSortWithColumnException();
        }

        return $this->repository->all($category, $sortBy);
    }

    public function store(string $name, string $description, $price, $image, ...$categoryIds)
    {
        $product = new Product();
        $product->name = $name;
        $product->description = $description;
        $product->price = $price;
        $product->image = $this->fileUploader->uploadBase64($image);

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
