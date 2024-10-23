<?php

namespace App\Service\Parser;

use App\DTO\ProductDTO;
use App\DTO\ProductImageDTO;
use App\Exception\NoProductsFoundException;
use App\Service\Product\ProductService;

class StylusProductParser extends AbstractParser
{
    public function __construct(private readonly ProductService $productService)
    {
    }

    public function createProductsFromUrl(string $url): array
    {
        $productDTOs = $this->extractProductData($url);

        if (empty($productDTOs)) {
            throw new NoProductsFoundException("No products were found at the provided URL: " . $url);
        }

        return $this->productService->createProducts($productDTOs);
    }

    public function extractProductData(string $url): array
    {
        $products = [];

        $stylusLink = 'https://stylus.ua';

        $domXPath = $this->loadDomXPathFromUrl($url);

        $productElements = $domXPath->query('//li[contains(@class, "sc-wQlsz ejIpxs")]');

        if ($productElements->length > 0) {
            foreach ($productElements as $productElement) {
                $productName = $this->getXPathValue(".//div[@class='sc-bKNyeQ bZokW']", $domXPath, $productElement);
                $productImage = $this->getXPathValue(".//img[contains(@class, 'sc-hrZbJn ibVicP')]", $domXPath, $productElement, 'src');
                $price = $this->getXPathValue(".//div[@class='sc-btdigE eicKSF']", $domXPath, $productElement);
                $productLink = $this->getXPathValue(".//a[@class='sc-bQMkFY fbLJpt']", $domXPath, $productElement, 'href');

                if (!$productName || !$price || !$productImage || !$productLink) {
                    continue;
                }

                $stylusProductLink = $stylusLink . $productLink;

                $priceData = $this->separatePriceAndCurrency($price);

                $products[] = new ProductDTO(
                    utf8_decode($productName),
                    $stylusProductLink,
                    [new ProductImageDTO($productImage)],
                    $priceData['price'],
                    $priceData['currency']
                );
            }
        }

        return $products;
    }

    private function separatePriceAndCurrency(string $parsedPriceString): array
    {
        $priceString = utf8_decode($parsedPriceString);
        $priceString = str_replace("\xC2\xA0", '', $priceString);

        $priceAmount = preg_replace('/[^\d]/', '', $priceString);
        $currency = preg_replace('/[\d\s]/', '', $priceString);

        return [
            'price' => $priceAmount,
            'currency' => $currency,
        ];
    }
}
