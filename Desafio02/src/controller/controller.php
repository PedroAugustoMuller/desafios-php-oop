<?php

namespace Imply\Desafio02\controller;

use Exception;
use Imply\Desafio02\DAO\ProductDAO;
use Imply\Desafio02\model\Product;
use Imply\Desafio02\service\FakeStoreAPI;
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
        if ($id === 0) {

            return $productDAO->readAllProducts();
        }
        return $productDAO->readProductById($id);
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
            if ($route['method'] != 'GET' && $route['method'] != 'DELETE') {
                
            }

        } catch (InvalidArgumentException $invalidArgumentException) {
            return $invalidArgumentException;
        }
    }

    /**
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

    /**
     * @param Product $product
     * @return void
     */
    public function createProductTableRow(Product $product)
    {
        echo "<tr>";
        echo "<td>" . $product->getId() . "</td>";
        echo "<td>" . $product->getTitle() . "</td>";
        echo "<td> R$ " . $product->getPrice() . "</td>";
        echo "<td>" . $product->getDescription() . "</td>";
        echo "<td>" . $product->getCategory() . "</td>";
        echo "<td><img src='" . $product->getImage() . "' alt='product-image' class='img-thumbnail'</td>";
        echo "<td>" . $product->getReviewRate() . "</td>";
        echo "</tr>";
    }
}