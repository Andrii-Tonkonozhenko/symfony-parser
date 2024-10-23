<?php

namespace App\Transformer;

use App\Entity\Product;

class ProductTransformer
{
    public function transformCollection(array $products): array
    {
        return array_map(fn($product) => $this->transform($product), $products);
    }

    public function transform(Product $product): array
    {
        $images = [];

        foreach ($product->getImages() as $image) {
            $images[] = [
                'src' => $image->getSrc(),
            ];
        }

        return [
            'id' => $product->getId(),
            'name' => $product->getName(),
            'amount' => $product->getAmount(),
            'currency' => $product->getCurrency(),
            'link' => $product->getLink(),
            'images' => $images,
        ];
    }
}
