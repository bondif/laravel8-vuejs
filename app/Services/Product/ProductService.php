<?php

namespace App\Services\Product;

use App\Exceptions\CannotSortWithColumnException;
use App\Exceptions\Category\MaxCategoriesExceededException;
use App\Models\Product\Product;
use App\Repository\Product\ProductRepository;
use App\Services\FileUploader;
use Illuminate\Database\Eloquent\Collection;

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

    public function all($category = null, $sortBy = null): Collection
    {
        if ($sortBy && !in_array($sortBy, $this->sortByColumns)) {
            throw new CannotSortWithColumnException();
        }

        return $this->repository->all($category, $sortBy);
    }

    public function store(string $name, string $description, float $price, $image, ...$categoryIds): Product
    {
        if (count($categoryIds) > self::MAX_CATEGORIES) {
            throw new MaxCategoriesExceededException();
        }

        $image = $this->fileUploader->uploadBase64($image);

        return $this->repository->save($name, $description, $price, $image, ...$categoryIds);
    }

    public function destroy(int $productId): bool
    {
        return $this->repository->delete($productId);
    }
}
