<?php

namespace Imply\Desafio02\DAO;

use http\Exception\InvalidArgumentException;
use Imply\Desafio02\DB\MySQL;
use PDO;
use PDOException;

class OrderDAO
{
    private object $MySQL;
    private const TABLE = 'orders';
    private const ITEMS_TABLE = 'items';
    private const PRODUCTS_TABLE = 'products';

    public function __construct()
    {
        $this->MySQL = new MySQL();
    }
    public function readAllOrders()
    {
        try {
            $stmt = "SELECT " . self::TABLE.".*, ".self::ITEMS_TABLE.".*, ". self::PRODUCTS_TABLE .".price, " . self::PRODUCTS_TABLE . ".title FROM ". self::TABLE . "
            INNER JOIN ". self::ITEMS_TABLE. " ON " . self::TABLE . ".order_id = ". self::ITEMS_TABLE .".item_order_id
            INNER JOIN ". self::PRODUCTS_TABLE." ON " . self::ITEMS_TABLE. ".item_product_id = ". self::PRODUCTS_TABLE .".product_id";
            $stmt = $this->MySQL->getDb()->prepare($stmt);
            $stmt->execute();
            $retorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if(empty($retorno))
            {
                throw new InvalidArgumentException("Nenhum registro encontrado");
            }
            return $retorno;
        }catch(PDOException $PDOException)
        {
            return $PDOException->getMessage();
        }catch(InvalidArgumentException $InvalidArgumentException)
        {
            return $InvalidArgumentException->getMessage();
        }
    }
    public function readOrderById(int $id)
    {
        try {
            $stmt = "SELECT " . self::TABLE.".*, ".self::ITEMS_TABLE.".*, ". self::PRODUCTS_TABLE .".price, " . self::PRODUCTS_TABLE . ".title FROM ". self::TABLE . "
            INNER JOIN ". self::ITEMS_TABLE. " ON " . self::TABLE . ".order_id = ". self::ITEMS_TABLE .".item_order_id
            INNER JOIN ". self::PRODUCTS_TABLE." ON " . self::ITEMS_TABLE. ".item_product_id = ". self::PRODUCTS_TABLE .".product_id
            WHERE ". self::TABLE . ".order_id = :id";
            $stmt = $this->MySQL->getDb()->prepare($stmt);
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            $retorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if(empty($retorno))
            {
                throw new InvalidArgumentException("Nenhum registro encontrado");
            }
            return $retorno;
        }catch(PDOException $PDOException)
        {
            return $PDOException->getMessage();
        }catch(InvalidArgumentException $InvalidArgumentException)
        {
            return $InvalidArgumentException->getMessage();
        }
    }
    public function readUsersOrders(int $id)
    {
        try {
            $stmt = "SELECT " . self::TABLE.".*, ".self::ITEMS_TABLE.".*, ". self::PRODUCTS_TABLE .".price, " . self::PRODUCTS_TABLE . ".title FROM ". self::TABLE . "
            INNER JOIN ". self::ITEMS_TABLE. " ON " . self::TABLE . ".order_id = ". self::ITEMS_TABLE .".item_order_id
            INNER JOIN ". self::PRODUCTS_TABLE." ON " . self::ITEMS_TABLE. ".item_product_id = ". self::PRODUCTS_TABLE .".product_id
            WHERE ". self::TABLE . ".order_user_id = :id";
            $stmt = $this->MySQL->getDb()->prepare($stmt);
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            $retorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if(empty($retorno))
            {
                throw new InvalidArgumentException("Nenhum registro encontrado");
            }
            return $retorno;
        }catch(PDOException $PDOException)
        {
            return $PDOException->getMessage();
        }catch(InvalidArgumentException $InvalidArgumentException)
        {
            return $InvalidArgumentException->getMessage();
        }
    }
}