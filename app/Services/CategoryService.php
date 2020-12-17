<?php

namespace App\Services;

use App\Models\Category;
use App\Repository\CategoryRepository;

class CategoryService
{
    private $repository;

    public function __construct(CategoryRepository $repository)
    {
        $this->repository = $repository;
    }

    public function store(string $name, int $parentId = null)
    {
        $category = new Category();
        $category->name = $name;
        $category->parent_id = $parentId;

        return $this->repository->save($category);
    }
}
