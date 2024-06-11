<?php

namespace Imply\Desafio02\Util;

class JsonUtil
{
    public static function treatJsonBody()
    {
        try
        {
            $postJson = json_decode(file_get_contents('php://input'), true);
        } catch( JsonException $e)
        {
            throw new InvalidArgumentException("Json Vazio");
        }

        if(is_array($postJson) && count($postJson) > 0)
        {
            return $postJson;
        }
    }

    public function processArray($array)
    {
        $data = [];
        $data['tipo'] = 'erro';
        $data['resposta'] = $array;
        if((is_array($array) && count($array) > 0))
        {
            $data['tipo'] = 'sucesso';
        }
        $this->returnJson($data);
    }

    private function returnJson($json)
    {
        header('Content-Type:application/json');
        header('Cache-Control: no-cache, no-store, must-revalidate');
        header('Access-Control-Allow-Methods: GET,POST,PUT,DELETE');
        echo (json_encode($json));
    }
}