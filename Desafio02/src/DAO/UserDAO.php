<?php

namespace Imply\Desafio02\DAO;

use Imply\Desafio02\DB\MySQL;

class UserDAO
{
    private object $MySQL;
    private const TABLE = 'users';

    public function __construct()
    {
        $this->MySQL = new MySQL();
    }
}