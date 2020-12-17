<?php


namespace App\Exceptions;


class CannotDeleteParentCategoryException extends \Exception
{
    protected $message = 'Cannot delete a parent category!';
}
