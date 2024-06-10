<?php

namespace Imply\Desafio02\service;

use Imply\Desafio02\model\Product;
use Imply\Desafio02\model\Review;

class FakeStoreAPI
{
    public function getApiProducts(){
        $url = 'https://fakestoreapi.com/products';
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $curl_response = curl_exec($curl);
        $decoded_response = json_decode($curl_response);
        curl_close($curl);
        return $decoded_response;
    }
    public function createApiProduct()
    {
        $products = $this->getApiProducts();
        $productsArray = array();
        foreach ($products as $product)
        {
            $id = $product->id;
            $title = $product->title;
            $price = $product->price;
            $description = $product->description;
            $category = $product->category;
            $image = $product->image;
            $review = new Review(0,$product->rating->rate,$product->rating->count);
            $productsArray[] = new Product($id, $title, $price, $description, $category, $image, $review);
        }
        return $productsArray;
    }
}