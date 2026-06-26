<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ProductService
{
    public function getProducts()
{
    $response = Http::get(config('api.base_url') . '/products');

    if ($response->failed()) {
        return [
            'products' => [],
            'categories' => []
        ];
    }

    $data = $response->json();
    $products = $data['products'] ?? [];

    // Remove duplicate images from all products
    foreach ($products as &$product) {
        if (isset($product['images']) && is_array($product['images'])) {
            $product['images'] = array_values(array_unique($product['images']));
        }
    }

    return [
        'products'   => $products,
        'categories' => $data['product_category'] ?? [],
    ];
}
}