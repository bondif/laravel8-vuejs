<?php

namespace App\Console\Commands\Category;

use App\Exceptions\Category\CannotDeleteParentCategoryException;
use App\Services\Category\CategoryService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

class DeleteCategory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'category:delete {categoryId}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete a category';

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
    public function handle(CategoryService $categoryService)
    {
        $categoryId = $this->argument('categoryId');

        $validator = Validator::make([
            'categoryId' => $categoryId
        ], [
            'categoryId' => 'required|exists:categories,id'
        ]);

        if ($validator->fails()) {
            $this->error($validator->errors()->first());
            return 0;
        }

        try {
            $categoryService->destroy($categoryId);
            $this->info('The category was deleted successfully!');
        } catch (CannotDeleteParentCategoryException $exception) {
            $this->error($exception->getMessage());
        } catch (\Exception $exception) {
            $this->error('Something went wrong, please try again!');
        }

        return 0;
    }
}
