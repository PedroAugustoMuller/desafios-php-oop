<?php

namespace Imply\Desafio02\DAO;

use Exception;
use Imply\Desafio02\DB\MySQL;
use PDOException;

class ReviewDAO
{
    private object $MySQL;
    private const TABLE = 'ratings';

    public function __construct()
    {
        $this->MySQL = new MySQL();
    }

    public function insertIntoReview($id): bool|string
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
            $this->MySQL->getDb()->rollBack();
            return false;
        } catch (PDOException $PDException) {
            return $PDException->getMessage();
        } catch (Exception $exception) {
            return $exception->getMessage();
        }
    }

    public function updateProductReview($reviewData): bool|string
    {
        try {
            $stmt = 'UPDATE '. self::TABLE. ' SET
                        rate = :rate,
                        count = :count
                        WHERE review_product_id = :review_product_id';
            $this->MySQL->getDb()->beginTransaction();
            $stmt = $this->MySQL->getDb()->prepare($stmt);
            $stmt->bindValue(':rate', $reviewData['rate']);
            $stmt->bindValue(':count', $reviewData['count']);
            $stmt->bindValue(':review_product_id', 1);
            $stmt->execute();
            if ($stmt->rowCount() == 1) {
                $this->MySQL->getDb()->commit();
                return true;
            }
            $this->MySQL->getDb()->rollBack();
            return false;
        } catch (PDOException $PDException) {
            return $PDException->getMessage();
        } catch (Exception $exception) {
            return $exception->getMessage();
        }
    }
}