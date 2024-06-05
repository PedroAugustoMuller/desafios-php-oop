<?php

namespace Imply\Desafio01\controller;

use Imply\Desafio01\model\Weather;

use Imply\Desafio01\DAO\WeatherDAO;
use Imply\Desafio01\service\WeatherAPI;

class Controller{
    
    function getCityWeather(string $cityName) : object
    {    
        $weatherDAO = new WeatherDAO();
        $weather = $weatherDAO->getWeatherFromDb($cityName);
        if($weather == null)
        {
            $weatherAPI = new WeatherAPI();
            $weather = $weatherAPI->getWeatherFromApi($cityName);
            $weatherDAO->insertWeatherIntoDb($weather);
            return $weather;
        }
        return $weather;
    }

}