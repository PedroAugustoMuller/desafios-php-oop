<?php

namespace Imply\Desafio02\DAO;

use Imply\Desafio02\DB\MySQL;
use InvalidArgumentException;
use PDO;
use PDOException;

class UserDAO
{
    private object $MySQL;
    private const TABLE = 'users';

    public function __construct()
    {
        $this->MySQL = new MySQL();
    }

    public function userLogin($login, $password)
    {
        try {
            $stmt = 'SELECT * FROM ' . self::TABLE . ' WHERE login = :login';
            $stmt = $this->MySQL->getDb()->prepare($stmt);
            $stmt->bindValue(':login', $login);
            $stmt->execute();
            $user = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($user) {
                if (password_verify($password, $user[0]['password'])) {
                    return $user[0];
                }
            }
            throw new InvalidArgumentException('Usuário ou senha inválidos');
        }catch (PDOException $e)
        {
            return $e->getMessage();
        } catch (InvalidArgumentException $exception)
        {
            return $exception->getMessage();
        }
    }
}