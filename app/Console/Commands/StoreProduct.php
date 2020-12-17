<?php

namespace App\Console\Commands;

use App\Exceptions\MaxCategoriesExceededException;
use App\Services\ProductService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

class StoreProduct extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'product:store {name} {description} {price} {image} {categoryIds*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Store a product';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(ProductService $productService)
    {
        $name = $this->argument('name');
        $description = $this->argument('description');
        $price = $this->argument('price');
        $image = $this->argument('image');
        $categoryIds = $this->argument('categoryIds');

        $validator = Validator::make([
            'name' => $name,
            'price' => $price,
            'categoryIds' => $categoryIds,
        ], [
            'name' => 'required|max:255',
            'price' => 'required|numeric|min:0',
            'categoryIds.*' => 'exists:categories,id',
        ]);

        if ($validator->fails()) {
            $this->error($validator->errors()->first());
            return 0;
        }

        try {
            $productService->store($name, $description, $price, $image, ...$categoryIds);
            $this->info('The product was created successfully!');
        } catch (MaxCategoriesExceededException $exception) {
            $this->error($exception->getMessage());
        } catch (\Exception $exception) {
            $this->error('Something went wrong, please try again!');
        }

        return 0;
    }
}
