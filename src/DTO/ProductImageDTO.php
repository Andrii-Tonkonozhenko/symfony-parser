<?php

namespace App\DTO;

class ProductImageDTO
{
    private string $src;

    public function __construct(string $src)
    {
        $this->src = $src;
    }

    public function getSrc(): string
    {
        return $this->src;
    }
}
