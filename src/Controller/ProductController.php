<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use App\Transformer\ProductTransformer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    public function __construct(
        private readonly ProductRepository $productRepository,
        private readonly ProductTransformer $productTransformer
    ) {
    }

    #[Route('/products', name: 'get_all_products', methods: ['GET'])]
    public function getAllProducts(): JsonResponse
    {
        $products = $this->productRepository->findAllProducts();

        $transformedProducts = $this->productTransformer->transformCollection($products);

        return new JsonResponse($transformedProducts);
    }
}
