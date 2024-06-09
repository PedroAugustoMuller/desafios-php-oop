<?php

namespace Imply\Desafio02\service;

class FakeStoreAPI
{
    public function getApiProducts(){
        $url = 'https://fakestoreapi.com/products';
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $curl_response = curl_exec($curl);
        $decoded_response = json_decode($curl_response);
        curl_close($curl);
        return $decoded_response;
    }
}