<?php

namespace Imply\Desafio01\DB;

use PDO;
use PDOException;
use Imply\Desafio01;

class MySQL
{
    private object $db;
    private const HOST = 'db';
    private const DB = 'clima';
    private const USER = 'root';
    private const SENHA = 'root';

    public function __construct()
    {
        $this->db = $this->setDB();
    }

    public function setDB()
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

    public function getDb()
    {
        return $this->db;
    }
}
