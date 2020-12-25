<?php

namespace App\Console\Commands\Category;

use App\Services\Category\CategoryService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

class StoreCategory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'category:store {name} {parentId?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a category';

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
     * @param CategoryService $categoryService
     * @return int
     */
    public function handle(CategoryService $categoryService)
    {
        $name = $this->argument('name');
        $parentId = $this->argument('parentId');

        $validator = Validator::make([
            'name' => $name,
            'parent_id' => $parentId
        ], [
            'name' => 'required|max:255',
            'parent_id' => 'nullable|exists:categories,id'
        ]);

        if ($validator->fails()) {
            $this->error($validator->errors()->first());
            return 0;
        }

        if ($categoryService->store($name, $parentId)) {
            $this->info('The category was created successfully!');
        } else {
            $this->error('Something went wrong, please try again!');
        }

        return 0;
    }
}
