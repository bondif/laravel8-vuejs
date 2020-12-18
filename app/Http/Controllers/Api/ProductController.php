<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Resources\Product;
use App\Http\Resources\ProductCollection;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index(Request $request)
    {
        $column = $request->get('sortBy');
        $category = $request->get('category');

        return new ProductCollection($this->productService->all($category, $column));
    }


    public function store(StoreProductRequest $request)
    {
        $name = $request->get('name');
        $description = $request->get('description');
        $price = $request->get('price');
        $image = $request->get('image');
        $categoryIds = $request->get('categoryIds');

        return new Product($this->productService->store($name, $description, $price, $image, ...$categoryIds));
    }
}
