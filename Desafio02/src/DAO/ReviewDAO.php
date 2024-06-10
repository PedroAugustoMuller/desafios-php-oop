<?php

namespace Imply\Desafio02\DAO;

use Exception;
use http\Exception\InvalidArgumentException;
use Imply\Desafio02\DB\MySQL;
use Imply\Desafio02\model\Review;
use PDOException;

class ReviewDAO
{
    private object $MySQL;
    private const TABLE = 'ratings';

    public function __construct()
    {
        $this->MySQL = new MySQL();
    }

    public function insertIntoReview($id)
    {
        try {
            $stmt = "INSERT INTO " . self::TABLE . "(rate,count,review_product_id)
        VALUES(:rate,:count,:review_product_id)";
            $this->MySQL->getDb()->beginTransaction();
            $stmt = $this->MySQL->getDb()->prepare($stmt);
            $stmt->bindValue(':rate', 0);
            $stmt->bindValue(':count', 0);
            $stmt->bindValue(':review_product_id', $id);
            $stmt->execute();
            if ($stmt->rowCount() == 1) {
                $this->MySQL->getDb()->commit();
                return true;
            }
        }catch (PDOException $PDException)
        {
            throw new InvalidArgumentException($PDException->getMessage());
        }
        catch (Exception $exception)
        {
            throw new InvalidArgumentException($exception->getMessage());
        }
        $this->MySQL->getDb()->rollBack();
        return false;
    }
}