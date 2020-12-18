<?php

namespace Tests\Feature;

use App\Exceptions\MaxCategoriesExceededException;
use App\Models\Category;
use App\Services\FileUploader;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Mockery\MockInterface;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    private $productService;

    private $testImage = 'http://localhost:8000/images/test_image.jpg';

    protected function setUp(): void
    {
        parent::setUp();
        $this->instance(
            FileUploader::class,
            Mockery::mock(FileUploader::class, function (MockInterface $mock) {
                $mock->shouldReceive('uploadBase64')->once()->andReturn($this->testImage);
            })
        );
        $this->productService = $this->app->make('App\Services\ProductService');
    }

    public function test_create_product()
    {
        $name = 'Product 1';
        $description = 'Description 1';
        $price = 399.9;

        // the is not used, but this how it should look like
        $image = 'data:image/png;base64,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';

        $this->productService->store($name, $description, $price, $image);

        $this->assertDatabaseHas('products', [
            'name' => $name,
            'description' => $description,
            'price' => $price,
            'image' => $this->testImage
        ]);
    }

    public function test_create_product_exception_when_more_than_two_categories()
    {
        $this->expectException(MaxCategoriesExceededException::class);

        $name = 'Product 1';
        $description = 'Description 1';
        $price = 399.9;
        $image = '';

        $this->productService->store($name, $description, $price, $image, 1, 2, 3);
    }

    public function test_create_product_with_categories()
    {
        Category::insert([
            [
                'name' => 'cat1'
            ],
            [
                'name' => 'cat2'
            ]
        ]);

        $name = 'Product 1';
        $description = 'Description 1';
        $price = 399.9;
        $image = '';

        $this->productService->store($name, $description, $price, $image, 1, 2);

        $this->assertDatabaseHas('products', [
            'name' => $name,
            'description' => $description,
            'price' => $price,
            'image' => $this->testImage
        ]);

        $this->assertDatabaseHas('category_product', [
            'product_id' => 2,
            'category_id' => 1
        ]);

        $this->assertDatabaseHas('category_product', [
            'product_id' => 2,
            'category_id' => 2
        ]);
    }
}
