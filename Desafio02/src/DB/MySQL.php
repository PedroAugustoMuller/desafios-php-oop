<?php

namespace Imply\Desafio02\DB;

use PDO;
use PDOException;

class MySQL
{
    private object $db;
    private const HOST = 'db';
    private const DB = 'MyFakeStore';
    private const USER = 'root';
    private const SENHA = 'root';

    public function __construct()
    {
        $this->db = $this->setDB();
    }

    public function setDB(): PDO
    {
        try {
            return new PDO(
                'mysql:host=' . self::HOST . '; dbname=' . self::DB . ';',
                self::USER,
                self::SENHA
            );
        } catch (PDOException $exception) {
            throw new PDOException($exception->getMessage());
        }
    }

    public function getDb(): PDO
    {
        return $this->db;
    }
}
