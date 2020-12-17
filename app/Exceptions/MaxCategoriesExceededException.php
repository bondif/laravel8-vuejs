<?php


namespace App\Exceptions;


class MaxCategoriesExceededException extends \Exception
{
    protected $message = 'A Product cant have more than 2 categories!';
}
