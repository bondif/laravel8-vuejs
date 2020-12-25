<?php


namespace App\Exceptions\Category;


class MaxCategoriesExceededException extends \Exception
{
    protected $message = 'A Product cant have more than 2 categories!';
}
