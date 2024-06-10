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
    private const TABLE = 'reviews';

    public function __construct()
    {
        $this->MySQL = new MySQL();
    }

    public function insertIntoReview(Review $review)
    {
        try {
            $stmt = "INSERT INTO " . self::TABLE . "(rating,quantity)
        VALUES(:rating,:quantity)";
            $this->MySQL->getDb()->beginTransaction();
            $stmt = $this->MySQL->getDb->prepare($stmt);
            $stmt->bindValue(':rating', $review->getRating());
            $stmt->bindValue(':quantity', $review->getQuantity());
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