<?php

namespace Imply\Desafio02\DAO;

use Exception;
use InvalidArgumentException;
use Imply\Desafio02\DB\MySQL;
use Imply\Desafio02\model\Product;
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

    public function readAllProducts(): array|string
    {
        try {
            $stmt = "SELECT * FROM " . self::TABLE . " INNER JOIN " . self::REVIEW_TABLE . " 
            ON " . self::TABLE . ".product_id = " . self::REVIEW_TABLE . ".review_product_id 
            WHERE status = 2";
            $stmt = $this->MySQL->getDb()->prepare($stmt);
            $stmt->execute();
            $retorno = $stmt->fetchAll($this->MySQL->getDb()::FETCH_ASSOC);
            if(empty($retorno))
            {
                throw new InvalidArgumentException("Nenhum Registro encontrado no banco de dados.");
            }
            return $retorno;
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
            $retorno = $stmt->fetchAll($this->MySQL->getDb()::FETCH_ASSOC);
            if(empty($retorno))
            {
                throw new InvalidArgumentException("Nenhum Registro encontrado no banco de dados.");
            }
            return $retorno;
        }catch(PDOException $PDOException)
        {
            return $PDOException->getMessage();
        }catch(Exception $exception)
        {
            return $exception->getMessage();
        }

    }

    public function readInactiveProducts()
    {
        try {
            $stmt = "SELECT * FROM " . self::TABLE . " INNER JOIN " . self::REVIEW_TABLE . " 
            ON " . self::TABLE . ".product_id = " . self::REVIEW_TABLE . ".review_product_id 
            WHERE status = 1";
            $stmt = $this->MySQL->getDb()->prepare($stmt);
            $stmt->execute();
            $retorno = $stmt->fetchAll($this->MySQL->getDb()::FETCH_ASSOC);
            if(empty($retorno))
            {
                throw new InvalidArgumentException("Nenhum Registro encontrado no banco de dados.");
            }
            return $retorno;
        } catch (PDOException $PDOException) {
            return $PDOException->getMessage();
        } catch (Exception $exception) {
            return $exception->getMessage();
        }
    }

    public function insertProduct(Product $product)
    {
        try {
            $stmt = "INSERT INTO " . self::TABLE . "(title,price,description,category,image,status) 
            VALUES (:title,:price,:description,:category,:image,2)";
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
            throw new InvalidArgumentException("Não foi possível inserir os dados.");
        } catch (PDOException $PDOException) {
            return $PDOException->getMessage();
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
        return 0;
    }

    public function updateProduct(Product $product): bool|string
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
            throw new InvalidArgumentException("Não foi possível alterar os dados.");
        } catch (PDOException $PDOException) {
            return $PDOException->getMessage();
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function setProductImage(string $imagePath, string $productId): bool|string
    {
        try {
            $stmt = "UPDATE " . self::TABLE . " SET
            image = :image
            WHERE product_id = :id";
            $this->MySQL->getDb()->beginTransaction();
            $stmt = $this->MySQL->getDb()->prepare($stmt);
            $stmt->bindValue(':image', $imagePath);
            $stmt->bindValue(':id',$productId );
            $stmt->execute();
            if ($stmt->rowCount() == 1) {
                $this->MySQL->getDb()->commit();
                return true;
            }
            throw new InvalidArgumentException("Não foi possível alterar a imagem do produto.");
        } catch (PDOException $PDOException) {
            return $PDOException->getMessage();
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function reactivateProduct(int $id): bool|string
    {
        try {
            $stmt = "UPDATE " . self::TABLE . " SET
            status = 2
            WHERE product_id = :id";
            $this->MySQL->getDb()->beginTransaction();
            $stmt = $this->MySQL->getDb()->prepare($stmt);
            $stmt->bindValue(':id',$id );
            $stmt->execute();
            if ($stmt->rowCount() == 1) {
                $this->MySQL->getDb()->commit();
                return true;
            }
            throw new InvalidArgumentException("Não foi possível reativar o produto");
        } catch (PDOException $PDOException) {
            return $PDOException->getMessage();
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function deleteProduct(int $id): bool|string
    {
        try {
            $stmt = "UPDATE " . self::TABLE . " SET
            status = 1
            WHERE product_id = :id";
            $this->MySQL->getDb()->beginTransaction();
            $stmt = $this->MySQL->getDb()->prepare($stmt);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            if ($stmt->rowCount() == 1) {
                $this->MySQL->getDb()->commit();
                return true;
            }
            throw new InvalidArgumentException("Não foi possível excluir os dados.");
        } catch (PDOException $PDOException) {
            return $PDOException->getMessage();
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
        return false;
    }
}