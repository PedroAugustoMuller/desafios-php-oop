<?php

namespace Imply\Desafio01\controller;

use Imply\Desafio01\model\Weather;

use Imply\Desafio01\model\WeatherDAO;
use Imply\Desafio01\model\WeatherAPI;

class Controller{
    
    function getCityWeather(string $cityName) : object{
        
        $weatherDAO = new WeatherDAO();
        $weather = $weatherDAO->getWeatherFromDb($cityName);
        if(is_object($weather))
        {
            echo "peguei do banco";
            return $weather;
        }
        echo "peguei da API";
        $weatherAPI = new WeatherAPI();
        $weather = $weatherAPI->getWeather($cityName);
        $weatherDAO->insertWeatherIntoDb($weather);
        return $weather;
    }

}