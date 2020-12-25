<?php


namespace App\Exceptions\Category;


class CannotDeleteParentCategoryException extends \Exception
{
    protected $message = 'Cannot delete a parent category!';
}
