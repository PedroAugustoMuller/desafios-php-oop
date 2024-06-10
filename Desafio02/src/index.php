<?php

namespace Imply\Desafio02;
use Exception;

require_once "../vendor/autoload.php";

try{
    
}catch(Exception $e)
{
    echo json_encode([
        "tipo" => "erro",
        "resposta"=> $e->getMessage()
    ]);
    exit;
}