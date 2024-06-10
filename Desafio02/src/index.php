<?php

namespace Imply\Desafio02;
use Exception;
use Imply\Desafio02\controller\controller;

require_once "../vendor/autoload.php";

try{
    $controller = new Controller();
    $controller->treatRequest();
}catch(Exception $e)
{
    echo json_encode([
        "tipo" => "erro",
        "resposta"=> $e->getMessage()
    ]);
    exit;
}