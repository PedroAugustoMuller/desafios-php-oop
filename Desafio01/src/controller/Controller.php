<?php

namespace Imply\Desafio01\controller;

use Imply\Desafio01\model\Weather;

class Controller{
    
    function getCityWeather(string $cityName){
        
        // return $weather = Weather::getWeather($cityName);
        Weather::getWeather($cityName);
    }

}