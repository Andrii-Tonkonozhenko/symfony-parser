<?php

namespace App\Service\Product;

use App\DTO\ProductDTO;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;

class ProductService
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly ProductImageService $productImageService
    ) {
    }

    public function createProducts(array $productDTOs): array
    {
        $products = [];

        foreach ($productDTOs as $productDTO) {
            if ($productDTO instanceof ProductDTO) {
                $products[] = $this->createProduct($productDTO, false);
            }
        }

        $this->entityManager->flush();

        return $products;
    }


    public function createProduct(ProductDTO $productDTO, bool $flush = true): Product
    {
        $product = new Product(
            $productDTO->getName(),
            $productDTO->getAmount(),
            $productDTO->getCurrency(),
            $productDTO->getLink()
        );

        foreach ($productDTO->getProductImages() as $productImage) {
            $this->productImageService->createProductImage($product, $productImage);
        }

        $this->entityManager->persist($product);

        if ($flush) {
            $this->entityManager->flush();
        }

        return $product;
    }
}
