<?php

namespace Imply\Desafio02\DAO;

use Exception;
use Imply\Desafio02\DB\MySQL;
use Imply\Desafio02\model\Item;
use InvalidArgumentException;
use PDO;
use PDOException;

class ItemDAO
{
    private object $MySQL;
    private const TABLE_NAME = "items";
    private const PRODUCTS_TABLE = "products";

    public function __construct()
    {
        $this->MySQL = new MySQL();
    }

    public function insertItem(int $id, Item $item): bool|string
    {
        try {
            $stmt = 'INSERT INTO ' . self::TABLE_NAME . ' (item_order_id,item_product_id,quantity) 
            VALUES(:item_order_id, :item_product_id, :quantity)';
            $this->MySQL->getDb()->beginTransaction();
            $stmt = $this->MySQL->getDb()->prepare($stmt);
            $stmt->bindValue(':item_order_id', $id);
            $stmt->bindValue(':item_product_id', $item->getProductId());
            $stmt->bindValue(':quantity', $item->getQuantity());
            $stmt->execute();
            if ($stmt->rowCount() == 1) {
                $this->MySQL->getDb()->commit();
                return true;
            }
            $this->MySQL->getDb()->rollBack();
            throw new InvalidArgumentException("Não foi possível cadastrar o item");
        } catch (PDOException $PDOException) {
            $this->MySQL->getDb()->rollBack();
            return $PDOException->getMessage();
        } catch (Exception $exception) {
            $this->MySQL->getDb()->rollBack();
            return $exception->getMessage();
        }
    }

    public function listItem(int $orderId)
    {
        try {
            $stmt = 'SELECT ' . self::TABLE_NAME . '.*, ' . self::PRODUCTS_TABLE . '.price, ' . self::PRODUCTS_TABLE . '.title  
                FROM ' . self::TABLE_NAME . ' 
                INNER JOIN ' . self::PRODUCTS_TABLE . ' ON ' . self::TABLE_NAME . '.item_product_id = ' . self::PRODUCTS_TABLE . '.product_id
                WHERE item_order_id = :item_order_id';
            $stmt = $this->MySQL->getDb()->prepare($stmt);
            $stmt->bindValue(':item_order_id', $orderId);
            $stmt->execute();
            $retorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (empty($retorno)) {
                throw new InvalidArgumentException("Nenhum registro encontrado");
            }
            return $retorno;
        } catch (PDOException $PDOException)
        {
            return $PDOException->getMessage();
        }catch (Exception $exception)
        {
            return $exception->getMessage();
        }
    }

    public function updateItem(Item $item)
    {

    }
}