<?php

namespace App\Service\Product;

use App\DTO\ProductImageDTO;
use App\Entity\Product;
use App\Entity\ProductImage;
use Doctrine\ORM\EntityManagerInterface;

class ProductImageService
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    public function createProductImage(Product $product, ProductImageDTO $imageDTO): ProductImage
    {
        $productImage = new ProductImage($imageDTO->getSrc());

        $product->addImage($productImage);

        $this->entityManager->persist($productImage);

        return $productImage;
    }
}
