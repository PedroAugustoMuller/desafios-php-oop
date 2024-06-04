<?php

namespace Imply\Desafio01\DB;
use PDO;
use PDOException;

class MySQL
{
    private object $db;

    public function __construct()
    {
        $this->db = $this->setDB();
    }

    public function setDB()
    {
        try {
            return new PDO(
                'mysql:host=' . HOST . '; dbname=' . DB . ';', USER, SENHA
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