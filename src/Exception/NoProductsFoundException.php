<?php

namespace App\Exception;

use RuntimeException;

class NoProductsFoundException extends RuntimeException
{
    public function __construct($message = "No products were found for the given URL.")
    {
        parent::__construct($message);
    }
}
