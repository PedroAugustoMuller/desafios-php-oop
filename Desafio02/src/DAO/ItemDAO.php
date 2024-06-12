<?php

namespace Imply\Desafio02\DAO;

use http\Exception\InvalidArgumentException;
use Imply\Desafio02\DB\MySQL;
use Imply\Desafio02\model\Item;
use PDO;
use PDOException;

class ItemDAO
{
    private object $MySQL;
    private const TABLE_NAME = "item";
    private const PRODUCTS_TABLE= "products";

    public function __construct()
    {
        $this->MySQL = new MySQL();
    }

    public function insertItem(int $orderId, Item $item)
    {
        try {
            $stmt = 'INSERT INTO ' . self::TABLE_NAME . '(item_order_id,item_product_id,quantity) VALUES(
                :item_order_id, :item_product_id, :quantity)';
            $stmt = $this->MySQL->getDb()->beginTransaction();
            $stmt = $this->MySQL->getDb()->prepare($stmt);
            $stmt->bindValue(':item_order_id', $item->getOrderId());
            $stmt->bindValue(':item_product_id', $item->getProductId());
            $stmt->bindValue(':quantity', $item->getQuantity());
            $stmt->execute();
            if ($stmt->rowCount() === 1) {
                $stmt = $this->MySQL->getDb()->commit();
                return true;
            }
            $stmt = $this->MySQL->getDb()->rollBack();
            throw new InvalidArgumentException("Não foi possível cadastrar o item");
        } catch (PDOException $PDOException)
        {
            return $PDOException->getMessage();
        }catch(Exception $exception)
        {
            return $exception->getMessage();
        }
    }

    public function listItem(int $orderId)
    {
        $stmt = 'SELECT '. self::TABLE_NAME .'.*, ' .self::PRODUCTS_TABLE .'.price, ' . self::PRODUCTS_TABLE . '.title  
        FROM ' . self::TABLE_NAME . ' 
        INNER JOIN '. self::PRODUCTS_TABLE . ' ON '. self::TABLE_NAME . '.item_product_id = '. self::PRODUCTS_TABLE . '.product_id;
        WHERE item_order_id = :item_order_id';
        $stmt = $this->MySQL->getDb()->prepare($stmt);
        $stmt->bindValue(':item_order_id',$orderId);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, Item::class);
        var_dump($stmt->fetchAll());
//        if($stmt->rowCount() === 1)
//        {
//
//        }
    }

    public function updateItem(Item $item)
    {

    }
}