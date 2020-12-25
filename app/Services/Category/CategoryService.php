<?php

namespace App\Services\Category;

use App\Exceptions\Category\CannotDeleteParentCategoryException;
use App\Models\Category\Category;
use App\Repository\Category\CategoryRepository;
use Illuminate\Database\Eloquent\Collection;

class CategoryService
{
    private $repository;

    public function __construct(CategoryRepository $repository)
    {
        $this->repository = $repository;
    }

    public function all(): Collection
    {
        return $this->repository->all();
    }

    public function store(string $name, int $parentId = null): Category
    {
        return $this->repository->save($name, $parentId);
    }

    public function destroy($categoryId): bool
    {
        $category = $this->repository->find($categoryId);

        if ($category->isParent()) {
            throw new CannotDeleteParentCategoryException();
        }

        return $this->repository->delete($categoryId);
    }
}
