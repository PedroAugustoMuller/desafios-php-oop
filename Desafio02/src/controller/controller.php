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
    /**
     * @param int $id
     * @return array|null
     */
    public function getProductsFromDb(int $id = 0)
    {
        $productDAO = new ProductDAO();
        if ($id == 0) {

            $products = $productDAO->readAllProducts();
            return $this->createProductsArray($products);
        }

        $product = $productDAO->readProductById(round($id));
        return $this->createProductsArray($product);
    }

    /**
     * @return Exception|InvalidArgumentException
     * @throws Exception
     */
    public function treatRequest()
    {
        try {
            $route = RoutesUtil::getRoutes();
            if ($route instanceof Exception) {
                throw $route;
            }
            $processRequest = new ProcessRequest($route);
            $data = $processRequest->processRequest();
            $jsonUtil = new JsonUtil();
            return $jsonUtil->processArray($data);
        } catch (InvalidArgumentException $invalidArgumentException) {
            return $invalidArgumentException;
        }
    }

    /**
     * @param Product $product
     * @return void
     */
    public function createProductTableRow(Product $product)
    {
        if(!empty($product->getImage()))
        {
            $image = "<td><img src='" . $product->getImage() . "' alt='product-image' class='img-thumbnail'</td>";
        }
        else
        {
            $image = "<td><img src='../../public/images/products/default-product-image.png' alt='product-image' class='img-thumbnail'</td>";
        }
        echo "<tr>";
        echo "<td>" . $product->getId() . "</td>";
        echo "<td>" . $product->getTitle() . "</td>";
        echo "<td> R$ " . $product->getPrice() . "</td>";
        echo "<td>" . $product->getDescription() . "</td>";
        echo "<td>" . $product->getCategory() . "</td>";
        echo $image;
        echo "<td>" . $product->getReviewRate() . "</td>";
        echo "</tr>";
    }

    //FACTORY
    private function createProductsArray(array $productsData): ?array
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

    /**
     * Funçao só foi usada para popular o DB pela primeira vez
     * @return void
     */
    public function populateDb()
    {
        $fakeStore = new FakeStoreAPI();
        $products = $fakeStore->createApiProduct();
        foreach ($products as $product) {
            $productDAO = new ProductDAO();
            $productDAO->insertIntoProducts($product);
        }
    }
}