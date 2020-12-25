<?php

namespace App\Http\Controllers\Api\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Resources\Product\Product as ProductResource;
use App\Http\Resources\Product\ProductCollection;
use App\Services\Product\ProductService;
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

        return new ProductResource($this->productService->store($name, $description, $price, $image, ...$categoryIds));
    }
}
