<?php

namespace App\Models\Product;

use App\Models\Category\Category;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

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
        return $this->categories()->get(['name'])
            ->map(function ($category) {
                return $category->name;
            })
            ->implode(', ');
    }
}
