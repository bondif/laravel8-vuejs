<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //
    }
}
