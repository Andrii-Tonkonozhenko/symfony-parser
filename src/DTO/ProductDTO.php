<?php

namespace App\DTO;

class ProductDTO
{
    private string $name;
    private string $link;
    private array $productImages;
    private float $amount;
    private string $currency;

    public function __construct(string $name, string $link, array $productImages, float $amount, string $currency)
    {
        $this->name = $name;
        $this->link = $link;
        $this->productImages = $productImages;
        $this->amount = $amount;
        $this->currency = $currency;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getLink(): string
    {
        return $this->link;
    }

    public function getProductImages(): array
    {
        return $this->productImages;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }
}
