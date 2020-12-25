<?php

namespace App\Console\Commands\Product;

use App\Services\Product\ProductService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

class DeleteProduct extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'product:delete {productId}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete a product';

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
     * @param ProductService $productService
     * @return int
     */
    public function handle(ProductService $productService)
    {
        $productId = $this->argument('productId');

        $validator = Validator::make([
            'productId' => $productId
        ], [
            'productId' => 'required|exists:products,id'
        ]);

        if ($validator->fails()) {
            $this->error($validator->errors()->first());
            return 0;
        }

        try {
            $productService->destroy($productId);
            $this->info('The product was deleted successfully!');
        } catch (\Exception $exception) {
            $this->error('Something went wrong, please try again!');
        }

        return 0;
    }
}
