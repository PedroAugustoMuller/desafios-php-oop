<?php

namespace Imply\Desafio02\DAO;

use Couchbase\QueryException;
use Error;
use Exception;
use Imply\Desafio02\DB\MySQL;
use Imply\Desafio02\model\Product;
use Imply\Desafio02\model\Review;
use PDOException;

class ProductDAO
{
    private object $MySQL;
    private const TABLE = 'products';
    private const REVIEW_TABLE = 'ratings';

    public function __construct()
    {
        $this->MySQL = new MySQL();
    }

    public function readAllProducts(): ?array
    {
        $stmt = "SELECT * FROM " . self::TABLE . " INNER JOIN ".self::REVIEW_TABLE." ON ".self::TABLE.".product_id = ".self::REVIEW_TABLE.".product_id";
        $stmt = $this->MySQL->getDb()->prepare($stmt);
        $stmt->execute();
        $productsData= $stmt->fetchAll($this->MySQL->getDb()::FETCH_ASSOC);
        return $this->createProductsArray($productsData);
    }
    public function readProductById(int $id)
    {
        $stmt = "SELECT * FROM " . self::TABLE . " 
        INNER JOIN ".self::REVIEW_TABLE." ON ".self::TABLE.".product_id = ".self::REVIEW_TABLE.".product_id 
        WHERE product_id = :id";
        $stmt = $this->MySQL->getDb()->prepare($stmt);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $productsData= $stmt->fetchAll($this->MySQL->getDb()::FETCH_ASSOC);
        return $this->createProductsArray($productsData);
    }
    public function createProduct(Product $product)
    {
        try {
            $stmt = "INSERT INTO ".self::TABLE."(title,price,description,category,image) 
            VALUES (:title,:price,:description,:category,:image)";
            $this->MySQL->getDb()->beginTransaction();
            $stmt = $this->MySQL->getDb()->prepare($stmt);
            $stmt->bindValue(':title', $product->getTitle());
            $stmt->bindValue(':price', $product->getPrice());
            $stmt->bindValue(':description', $product->getDescription());
            $stmt->bindValue(':category', $product->getCategory());
            $stmt->bindValue(':image', $product->getImage());
            $stmt->execute();
            if ($stmt->rowCount() == 1)
            {
                $this->MySQL->getDb()->commit();
                return true;
            }
        }
        catch (PDOException $PDOException)
        {
            return $PDOException;
        }
        catch (Exception $ex)
        {
            return $ex;
        }
    }
    public function updateProduct(Product $product){
        //TODO
    }
    public function deleteProduct(int $id){
        //TODO
    }
    private function createProductsArray(array $productsData): ?array
    {
        if (empty($productsData))
        {
            return null;
        }
        $products = array();
        foreach ($productsData as $productData)
        {
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
            $products[] = new Product($id,$title, $price, $description, $category, $image,$review);
        }
        return $products;
    }
}