<?php

namespace Imply\Desafio02\DAO;

use InvalidArgumentException;
use Imply\Desafio02\DB\MySQL;
use Imply\Desafio02\model\Order;
use PDO;
use PDOException;

class OrderDAO
{
    private object $MySQL;
    private const TABLE = 'orders';

    public function __construct()
    {
        $this->MySQL = new MySQL();
    }

    public function readAllOrders()
    {
        try {
            $stmt = 'SELECT * FROM ' . self::TABLE;
            $stmt = $this->MySQL->getDb()->prepare($stmt);
            $stmt->execute();
            $retorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (empty($retorno)) {
                throw new InvalidArgumentException("Nenhum registro encontrado");
            }
            foreach ($retorno as &$order) {
                $itemDAO = new ItemDAO();
                $order['items'] = $itemDAO->listItem($order["order_id"]);
            }
            return $retorno;
        } catch (PDOException $PDOException) {
            return $PDOException->getMessage();
        } catch (InvalidArgumentException $InvalidArgumentException) {
            return $InvalidArgumentException->getMessage();
        }
    }

    public function readOrderById(int $id)
    {

        try {
            $stmt = 'SELECT * FROM ' . self::TABLE . ' WHERE order_id = :id AND status = 1 OR status = 3';
            $stmt = $this->MySQL->getDb()->prepare($stmt);
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            $retorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (empty($retorno)) {
                throw new InvalidArgumentException("Nenhum registro encontrado");
            }
            foreach ($retorno as &$order) {
                $itemDAO = new ItemDAO();
                $order['items'] = $itemDAO->listItem($order["order_id"]);
            }
            return $retorno;
        } catch (PDOException $PDOException) {
            return $PDOException->getMessage();
        } catch (InvalidArgumentException $InvalidArgumentException) {
            return $InvalidArgumentException->getMessage();
        }
    }

    public function readUsersOrders(int $id)
    {
        try {
            $stmt = 'SELECT * FROM ' . self::TABLE . ' 
            WHERE order_user_id = :id AND status = 1 OR status = 3';
            $stmt = $this->MySQL->getDb()->prepare($stmt);
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            $retorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (empty($retorno)) {
                throw new InvalidArgumentException("Nenhum registro encontrado");
            }
            foreach ($retorno as &$order) {
                $itemDAO = new ItemDAO();
                $order['items'] = $itemDAO->listItem($order["order_id"]);
            }
            return $retorno;
        } catch (PDOException $PDOException) {
            return $PDOException->getMessage();
        } catch (InvalidArgumentException $InvalidArgumentException) {
            return $InvalidArgumentException->getMessage();
        }
    }

    public function insertOrder(Order $order): bool|string
    {
        try {
            $stmt = "INSERT INTO " . self::TABLE . "(order_user_id, order_date, status) 
            VALUES (:order_user_id,:order_date,:status)";
            $this->MySQL->getDb()->beginTransaction();
            $stmt = $this->MySQL->getDb()->prepare($stmt);
            $stmt->bindValue(':order_user_id', $order->getUserId());
            $stmt->bindValue(':order_date', $order->getDate());
            $stmt->bindValue(':status', $order->getStatusEnum());
            $stmt->execute();
            if ($stmt->rowCount() < 1) {
                $this->MySQL->getDb()->rollBack();
                throw new InvalidArgumentException("Não foi possível inserir o pedido");
            }
            $id = $this->MySQL->getDb()->lastInsertId();
            $this->MySQL->getDb()->commit();
            foreach ($order->getItems() as $item) {
                $itemDAO = new ItemDAO();
                $resultado = $itemDAO->insertItem($id, $item);
                if (!$resultado) {
                    throw new InvalidArgumentException("Erro ao inserir item no banco");
                }
            }
            return true;
        } catch (PDOException $PDOException) {
            $this->MySQL->getDb()->rollBack();
            return $PDOException->getMessage();
        } catch (InvalidArgumentException $InvalidArgumentException) {
            $this->MySQL->getDb()->rollBack();
            return $InvalidArgumentException->getMessage();
        }
    }

    public function softDeleteOrderById(int $id): bool
    {
        try {
                $stmt = "UPDATE " . self::TABLE . " SET
                    status = 2 
                    WHERE order_id = :id AND status = 1 OR status = 3";
                $this->MySQL->getDb()->beginTransaction();
                $stmt = $this->MySQL->getDb()->prepare($stmt);
                $stmt->bindParam(":id", $id);
                $stmt->execute();
                if ($stmt->rowCount() < 1) {
                    $this->MySQL->getDb()->rollBack();
                    throw new InvalidArgumentException("Pedido já foi desativado");
                }
                $this->MySQL->getDb()->commit();
                return true;
        }catch(PDOException $PDOException)
        {
            $this->MySQL->getDb()->rollBack();
            return $PDOException->getMessage();
        }catch(InvalidArgumentException $InvalidArgumentException)
        {
            $this->MySQL->getDb()->rollBack();
            return $InvalidArgumentException->getMessage();
        }
    }
}