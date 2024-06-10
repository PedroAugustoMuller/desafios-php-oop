<?php

namespace Imply\Desafio02\DAO;

use Couchbase\QueryException;
use Error;
use Exception;
use Imply\Desafio02\DB\MySQL;
use Imply\Desafio02\model\Product;
use Imply\Desafio02\model\Review;
use PDO;
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
        try {
            $stmt = "SELECT * FROM " . self::TABLE . " INNER JOIN " . self::REVIEW_TABLE . " 
            ON " . self::TABLE . ".product_id = " . self::REVIEW_TABLE . ".review_product_id 
            WHERE status = 2";
            $stmt = $this->MySQL->getDb()->prepare($stmt);
            $stmt->execute();
            return $stmt->fetchAll($this->MySQL->getDb()::FETCH_ASSOC);
        } catch (PDOException $PDOException) {
            return $PDOException->getMessage();
        } catch (Exception $exception) {
            return $exception->getMessage();
        }
    }

    public function readProductById(int $id)
    {
        try {
            $stmt = "SELECT * FROM " . self::TABLE . " 
                INNER JOIN " . self::REVIEW_TABLE . " ON " . self::TABLE . ".product_id = " . self::REVIEW_TABLE . ".review_product_id 
                WHERE product_id = :id AND status = 2";
            $stmt = $this->MySQL->getDb()->prepare($stmt);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $productsData = $stmt->fetchAll($this->MySQL->getDb()::FETCH_ASSOC);
        }catch(PDOException $PDOException)
        {
            return $PDOException->getMessage();
        }catch(Exception $exception)
        {
            return $exception->getMessage();
        }

    }

    public function insertProduct(Product $product)
    {
        try {
            $stmt = "INSERT INTO " . self::TABLE . "(title,price,description,category,image) 
            VALUES (:title,:price,:description,:category,:image)";
            $this->MySQL->getDb()->beginTransaction();
            $stmt = $this->MySQL->getDb()->prepare($stmt);
            $stmt->bindValue(':title', $product->getTitle());
            $stmt->bindValue(':price', $product->getPrice());
            $stmt->bindValue(':description', $product->getDescription());
            $stmt->bindValue(':category', $product->getCategory());
            $stmt->bindValue(':image', $product->getImage());
            $stmt->execute();
            if ($stmt->rowCount() == 1) {
                $id = $this->MySQL->getDb()->lastInsertId();
                $this->MySQL->getDb()->commit();
                return $id;
            }
        } catch (PDOException $PDOException) {
            return $PDOException->getMessage();
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
        return 0;
    }

    public function updateProduct(Product $product)
    {
        try {
            $stmt = "UPDATE " . self::TABLE . " SET
            title = :title,
            price = :price,
            description = :description,
            category = :category,
            image = :image
            WHERE product_id = :id";
            $this->MySQL->getDb()->beginTransaction();
            $stmt = $this->MySQL->getDb()->prepare($stmt);
            $stmt->bindValue(':title', $product->getTitle());
            $stmt->bindValue(':price', $product->getPrice());
            $stmt->bindValue(':description', $product->getDescription());
            $stmt->bindValue(':category', $product->getCategory());
            $stmt->bindValue(':image', $product->getImage());
            $stmt->bindValue(':id', $product->getId());
            $stmt->execute();
            if ($stmt->rowCount() == 1) {
                $this->MySQL->getDb()->commit();
                return true;
            }
        } catch (PDOException $PDOException) {
            return $PDOException->getMessage();
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
        return false;
    }

    public function deleteProduct(int $id)
    {
        try {
            $stmt = "UPDATE " . self::TABLE . " SET
            status = :status
            WHERE product_id = :id";
            $this->MySQL->getDb()->beginTransaction();
            $stmt = $this->MySQL->getDb()->prepare($stmt);
            $stmt->bindValue(':status',1);
            $stmt->bindValue(':id', $id);
            $stmt->execute();
            if ($stmt->rowCount() == 1) {
                $this->MySQL->getDb()->commit();
                return true;
            }
        } catch (PDOException $PDOException) {
            return $PDOException->getMessage();
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
        return false;
    }
}