<?php


namespace App\Exceptions;


class CannotSortWithColumnException extends \Exception
{
    protected $message = 'Cannot sort with the given column';
}
