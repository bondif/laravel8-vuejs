<?php

namespace App\Services\Category;

use App\Exceptions\Category\CannotDeleteParentCategoryException;
use App\Models\Category\Category;
use App\Repository\Category\CategoryRepository;

class CategoryService
{
    private $repository;

    public function __construct(CategoryRepository $repository)
    {
        $this->repository = $repository;
    }

    public function all()
    {
        return $this->repository->all();
    }

    public function store(string $name, int $parentId = null)
    {
        $category = new Category();
        $category->name = $name;
        $category->parent_id = $parentId;

        return $this->repository->save($category);
    }

    public function destroy($id)
    {
        $category = new Category();
        $category->id = $id;

        if ($category->isParent()) {
            throw new CannotDeleteParentCategoryException();
        }

        return $this->repository->delete($category);
    }
}