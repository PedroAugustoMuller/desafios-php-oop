<?php

namespace Imply\Desafio01\controller;

use Imply\Desafio01\model\Weather;

use Imply\Desafio01\model\WeatherDAO;
use Imply\Desafio01\model\WeatherAPI;

class Controller{
    
    function getCityWeather(string $cityName) : object{
        
        // return $weather = Weather::getWeather($cityName);
        // $weatherDAO = new WeatherDAO();
        // $weather = $weatherDAO->getWeatherFromDb($cityName);
        $weatherAPI = new WeatherAPI();
       return $weather = $weatherAPI->getWeather($cityName);
    }

}