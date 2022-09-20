<?php

namespace App\Repositories;

class ProductRepository
{
    public function getProducts($request)
    {
        $path = public_path() . "/products.json";
        $json = json_decode(file_get_contents($path), true);
        $products = $json['products'];
        $response['products'] = [];
        foreach ($products as $product) {
            $discount = null;
            $price =  $product['price'];
            unset($product['price']);
            $product['price']['original'] = $price;
            $product['price']['final'] = $price;
            $product['price']['discount_percentage'] = $discount;
            $product['price']['currency'] = 'EUR';

            if($product['category'] == 'insurance') {
                $discount = 30;
                $product = $this->getDiscount($product, $discount, $price);
            }

            if($product['sku'] == '000003') {
                $discount = 15;
                $product = $this->getDiscount($product, $discount, $price);
            }

            if ($request->has('category')) {
                if ($request->category == $product['category']) {
                    $response['products'][] = $product;
                }
            } else {
                $response['products'][] = $product;
            }
        }
        return $response;
    }

    private function getDiscount($product, $discount, $price)
    {
        $discount_price = ($discount / 100) * $price;
        $product['price']['original'] = $price;
        $product['price']['final'] = intval($price - $discount_price);
        $product['price']['discount_percentage'] = $discount."%";
        return $product;
    }
}
