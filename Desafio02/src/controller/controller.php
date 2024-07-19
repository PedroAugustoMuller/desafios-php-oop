<?php

namespace Imply\Desafio02\controller;

use Exception;
use Imply\Desafio02\DAO\ProductDAO;
use Imply\Desafio02\model\Product;
use Imply\Desafio02\model\Review;
use Imply\Desafio02\service\FakeStoreAPI;
use Imply\Desafio02\service\ProcessRequest;
use Imply\Desafio02\Util\JsonUtil;
use Imply\Desafio02\Util\RoutesUtil;
use InvalidArgumentException;

class controller
{
    public function getProductsFromDb()
    {
        $productDAO = new ProductDAO();
        $products = $productDAO->readAllProducts();
        return $this->createProductsArray($products);
    }

    public function treatRequest()
    {
        try {
            $jsonUtil = new JsonUtil();
            $route = RoutesUtil::getRoutes();
            if ($route instanceof Exception) {
                return $jsonUtil->processArray($route->getMessage());
            }
            $processRequest = new ProcessRequest($route);
            $data = $processRequest->processRequest();
            return $jsonUtil->processArray($data);
        } catch (InvalidArgumentException $invalidArgumentException) {
            return $invalidArgumentException;
        }
    }

    private function createProductsArray($productsData): ?array
    {
        if (empty($productsData)) {
            return null;
        }
        $products = array();
        foreach ($productsData as $productData) {
            $id = $productData["product_id"];
            $title = $productData['title'];
            $price = $productData['price'];
            $description = $productData['description'];
            $category = $productData['category'];
            $image = $productData['image'];
            $reviewId = $productData['review_id'];
            $rate = $productData['rate'];
            $count = $productData['count'];
            $review = new Review($reviewId, $rate, $count);
            $product = new Product($id, $title, $price, $description, $category, $image);
            $product->setReview($review);
            $products[] = $product;
        }
        return $products;
    }
}