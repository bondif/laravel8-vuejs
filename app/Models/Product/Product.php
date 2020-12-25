<?php

namespace App\Models\Product;

use App\Models\Category\Category;
use App\Repository\Product\ProductRepository;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    private $productRepository;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->productRepository = resolve(ProductRepository::class);
    }

    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function getCategoriesStrAttribute()
    {
        return $this->productRepository->getCategoriesAsString($this->getKey());
    }
}
